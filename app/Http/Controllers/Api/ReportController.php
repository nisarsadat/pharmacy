<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\OwnerPickup;
use App\Models\Product;
use App\Models\Salary;
use App\Models\Sale;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SALES REPORT
    |--------------------------------------------------------------------------
    */

    public function salesReport()
    {
        return response()->json([
            'count' => Sale::count(),
            'total_amount' => Sale::sum('total_amount'),
            'final_amount' => Sale::sum('final_amount'),
            'paid_amount' => Sale::sum('paid_amount'),
            'due_amount' => Sale::sum('due_amount'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SALES DETAILS
    |--------------------------------------------------------------------------
    */

    public function saleDetails($id)
    {
        return Sale::with([
            'customer',
            'account',
            'warehouse',
            'items'
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER REPORT
    |--------------------------------------------------------------------------
    */

    public function customerReport()
    {
        return Customer::withCount('sales')->get();
    }

    public function customerDetails($id)
    {
        return Customer::with('sales.items')->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | EMPLOYEE REPORT
    |--------------------------------------------------------------------------
    */

    public function employeeReport()
    {
        return Employee::withCount([
            'attendances',
            'salaries'
        ])->get();
    }

    public function employeeDetails($id)
    {
        return Employee::with([
            'attendances',
            'salaries'
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT REPORT
    |--------------------------------------------------------------------------
    */

    public function productReport()
    {
        return Product::with([
            'warehouse',
            'productType'
        ])->get();
    }

    public function productDetails($id)
    {
        return Product::with([
            'warehouse',
            'productType',
            'images'
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | LOAN REPORT
    |--------------------------------------------------------------------------
    */

    public function loanReport()
    {
        return response()->json([
            'total_loans' => Loan::count(),
            'loan_amount' => Loan::sum('total_amount'),
            'paid_amount' => Loan::sum('paid_amount'),
            'remaining_amount' => Loan::sum('remaining_amount'),
        ]);
    }

    public function loanDetails($id)
    {
        return Loan::with([
            'customer',
            'sale',
            'payments'
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT REPORT
    |--------------------------------------------------------------------------
    */

    public function accountReport()
    {
        return Account::withCount([
            'expenses',
            'ownerPickups',
            'salaries'
        ])->get();
    }

    public function accountDetails($id)
    {
        return Account::with([
            'expenses',
            'ownerPickups',
            'salaries'
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPENSE REPORT
    |--------------------------------------------------------------------------
    */

    public function expenseReport()
    {
        return response()->json([
            'total_expenses' => Expense::sum('amount'),
            'categories' => ExpenseCategory::count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | OWNER PICKUP REPORT
    |--------------------------------------------------------------------------
    */

    public function ownerPickupReport()
    {
        return response()->json([
            'count' => OwnerPickup::count(),
            'total_amount' => OwnerPickup::sum('amount'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SALARY REPORT
    |--------------------------------------------------------------------------
    */

    public function salaryReport()
    {
        return response()->json([
            'count' => Salary::count(),
            'total_salary' => Salary::sum('total_salary'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE REPORT
    |--------------------------------------------------------------------------
    */

    public function attendanceReport()
    {
        return response()->json([
            'present' => Attendance::where('status', 'present')->count(),
            'absent' => Attendance::where('status', 'absent')->count(),
            'leave' => Attendance::where('status', 'leave')->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHARTS
    |--------------------------------------------------------------------------
    */

    public function salesChart()
    {
        return Sale::selectRaw("
                DATE(date) as day,
                SUM(final_amount) as total
            ")
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    public function expenseChart()
    {
        return ExpenseCategory::select(
                'expense_categories.name'
            )
            ->join(
                'expenses',
                'expense_categories.id',
                '=',
                'expenses.expense_category_id'
            )
            ->selectRaw('SUM(expenses.amount) as total')
            ->groupBy('expense_categories.name')
            ->get();
    }

    public function warehouseChart()
    {
        return Warehouse::select('name')
            ->withCount('products')
            ->get();
    }

    public function customerSalesChart()
    {
        return Customer::select('id','name')
            ->withCount('sales')
            ->get();
    }

    public function accountBalanceChart()
    {
        return Account::select(
            'id',
            'name',
            'price'
        )->get();
    }

    public function dashboardChart()
    {
        return response()->json([
            [
                'name' => 'Sales',
                'value' => Sale::sum('final_amount')
            ],
            [
                'name' => 'Expenses',
                'value' => Expense::sum('amount')
            ],
            [
                'name' => 'Salaries',
                'value' => Salary::sum('total_salary')
            ],
            [
                'name' => 'Loans',
                'value' => Loan::sum('remaining_amount')
            ]
        ]);
    }
}