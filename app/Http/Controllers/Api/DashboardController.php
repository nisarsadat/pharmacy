<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\User;
use App\Models\Employee;
use App\Models\Account;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Summary Cards
    |--------------------------------------------------------------------------
    */

    public function summary()
    {
        $today = Carbon::today();

        $todaySales = Sale::whereDate('date', $today)
            ->sum('final_amount');

        $monthSales = Sale::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('final_amount');

        $todayExpense = Expense::whereDate('date', $today)
            ->sum('amount');

        $totalExpense = Expense::sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Profit Calculation
        |--------------------------------------------------------------------------
        */
        $totalProfit = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('SUM((sale_items.price - products.main_price) * sale_items.quantity) as profit')
            ->value('profit');

        $todayProfit = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.date', $today)
            ->selectRaw('SUM((sale_items.price - products.main_price) * sale_items.quantity) as profit')
            ->value('profit');

        return response()->json([
            'today_sales' => $todaySales,
            'month_sales' => $monthSales,
            'total_profit' => $totalProfit ?? 0,
            'today_profit' => $todayProfit ?? 0,
            'today_expense' => $todayExpense,
            'total_expense' => $totalExpense,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Weekly Sales Chart
    |--------------------------------------------------------------------------
    */

    public function weeklySales()
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $sales = Sale::whereBetween('date', [$start, $end])
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('l');
            });

        $result = [];

        foreach ($sales as $day => $records) {
            $result[] = [
                'day' => $day,
                'sales_count' => $records->count(),
                'sale_ids' => $records->pluck('id'),
                'amount' => $records->sum('final_amount')
            ];
        }

        return response()->json($result);
    }

    /*
    |--------------------------------------------------------------------------
    | Monthly Sales Chart
    |--------------------------------------------------------------------------
    */

    public function monthlySales()
    {
        $sales = Sale::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('d');
            });

        $result = [];

        foreach ($sales as $day => $records) {
            $result[] = [
                'day' => $day,
                'sales_count' => $records->count(),
                'sale_ids' => $records->pluck('id'),
                'amount' => $records->sum('final_amount')
            ];
        }

        return response()->json($result);
    }

    /*
    |--------------------------------------------------------------------------
    | Top Customers
    |--------------------------------------------------------------------------
    */

    public function topCustomers()
    {
        $customers = Customer::withCount('sales')
            ->withSum('sales', 'final_amount')
            ->orderByDesc('sales_sum_final_amount')
            ->take(5)
            ->get();

        return response()->json($customers);
    }

    /*
    |--------------------------------------------------------------------------
    | Monthly Top Customers
    |--------------------------------------------------------------------------
    */

    public function topCustomersMonthly()
    {
        $customers = Customer::select(
                'customers.id',
                'customers.name',
                'customers.phone_number'
            )
            ->join('sales', 'customers.id', '=', 'sales.customer_id')
            ->whereMonth('sales.date', now()->month)
            ->whereYear('sales.date', now()->year)
            ->groupBy(
                'customers.id',
                'customers.name',
                'customers.phone_number'
            )
            ->selectRaw('SUM(sales.final_amount) as total')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return response()->json($customers);
    }

    /*
    |--------------------------------------------------------------------------
    | Stock Alert
    |--------------------------------------------------------------------------
    */

    public function stockAlert()
    {
        $products = Product::where('product_quantity', '<=', 10)
            ->select(
                'id',
                'name',
                'product_quantity',
                'expire_date'
            )
            ->get();

        return response()->json($products);
    }

    /*
    |--------------------------------------------------------------------------
    | Top Selling Products
    |--------------------------------------------------------------------------
    */

    public function topSellingProducts()
    {
        $products = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name'
            )
            ->selectRaw('SUM(sale_items.quantity) as total_sold')
            ->groupBy(
                'products.id',
                'products.name'
            )
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return response()->json($products);
    }

    /*
    |--------------------------------------------------------------------------
    | Pie Chart Data
    |--------------------------------------------------------------------------
    */

    public function pieChart()
    {
        return response()->json([
            'sales' => Sale::sum('final_amount'),
            'expenses' => Expense::sum('amount'),
            'loans' => Loan::sum('remaining_amount'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Statistics
    |--------------------------------------------------------------------------
    */

    public function statistics()
    {
        return response()->json([
            'customers' => Customer::count(),
            'employees' => Employee::count(),
            'users' => User::count(),
            'products' => Product::count(),
            'accounts' => Account::count(),
            'sales' => Sale::count(),
            'loans' => Loan::count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Expire Soon Products
    |--------------------------------------------------------------------------
    */

    public function expireSoon()
    {
        $products = Product::whereBetween(
                'expire_date',
                [now(), now()->addDays(30)]
            )
            ->select(
                'id',
                'name',
                'expire_date',
                'product_quantity'
            )
            ->get();

        return response()->json($products);
    }

    /*
    |--------------------------------------------------------------------------
    | Sales VS Expenses Chart
    |--------------------------------------------------------------------------
    */

    public function salesExpenseChart()
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {

            $sales = Sale::whereMonth('date', $i)
                ->whereYear('date', now()->year)
                ->sum('final_amount');

            $expense = Expense::whereMonth('date', $i)
                ->whereYear('date', now()->year)
                ->sum('amount');

            $data[] = [
                'month' => $i,
                'sales' => $sales,
                'expenses' => $expense
            ];
        }

        return response()->json($data);
    }
}