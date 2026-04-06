<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
class ExpenseController extends Controller
{
    /**
     * Display a paginated list of expenses
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $expenses = Expense::with(['category', 'account'])
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'items' => ExpenseResource::collection($expenses->items()),
            'pagination' => [
                'total' => $expenses->total(),
                'per_page' => $expenses->perPage(),
                'current_page' => $expenses->currentPage(),
                'last_page' => $expenses->lastPage(),
                'from' => $expenses->firstItem(),
                'to' => $expenses->lastItem(),
            ]
        ]);
    }

    /**
     * Store a new expense
     */
   use App\Models\Account;

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();

        $account = Account::findOrFail($data['account_id']);

        if ($account->price < $data['amount']) {
            return response()->json([
                'message' => 'Not enough balance'
            ], 400);
        }

        $account->price -= $data['amount'];
        $account->save();

        $expense = Expense::create($data);

        return new ExpenseResource($expense);
    }

    /**
     * Display a single expense
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }

    /**
     * Update an expense
     */
   public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $data = $request->validated();

        $account = $expense->account;

        // برگرداندن پول قبلی
        $account->price += $expense->amount;
        $account->save();

        // چک کردن
        if ($account->price < $data['amount']) {
            return response()->json([
                'message' => 'Not enough balance'
            ], 400);
        }

        // کم کردن دوباره
        $account->price -= $data['amount'];
        $account->save();

        $expense->update($data);

        return new ExpenseResource($expense);
    }

    /**
     * Delete an expense
     */
    public function destroy(Expense $expense)
    {
        $account = $expense->account;

        // return money
        $account->price += $expense->amount;
        $account->save();

        $expense->delete();

        return response()->json([
            'message' => 'موفقانه حذف شد!'
        ]);
    }
    
}