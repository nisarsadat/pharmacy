<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Account;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    // ✅ GET ALL (with pagination)
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $salaries = Salary::with(['employee', 'account'])
            ->latest()
            ->paginate($perPage);

        return response()->json($salaries);
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'account_id' => 'required|exists:accounts,id',
            'date' => 'required|date',
            'override' => 'nullable|numeric',
            'fine' => 'nullable|numeric',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $account = Account::findOrFail($request->account_id);

        // 🔴 prevent duplicate salary in same month
        $exists = Salary::where('employee_id', $employee->id)
            ->whereMonth('date', date('m', strtotime($request->date)))
            ->whereYear('date', date('Y', strtotime($request->date)))
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'معاش این ماه پرداخته شده است'
            ], 400);
        }

        $baseSalary = $employee->salary_amount;
        $override = $request->override ?? 0;
        $fine = $request->fine ?? 0;

        $totalSalary = $baseSalary + $override - $fine;

        // 🔴 check account balance
        if ($account->price < $totalSalary) {
            return response()->json([
                'message' => 'Not enough balance in account'
            ], 400);
        }

        // 🔥 deduct money
        $account->price -= $totalSalary;
        $account->save();

        $salary = Salary::create([
            'employee_id' => $employee->id,
            'account_id' => $account->id,
            'date' => $request->date,
            'base_salary' => $baseSalary,
            'override' => $override,
            'fine' => $fine,
            'total_salary' => $totalSalary,
        ]);

        return response()->json($salary, 201);
    }

    // ✅ SHOW ONE
    public function show($id)
    {
        $salary = Salary::with(['employee', 'account'])->find($id);

        if (!$salary) {
            return response()->json([
                'message' => 'Salary not found'
            ], 404);
        }

        return response()->json($salary);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $salary = Salary::find($id);

        if (!$salary) {
            return response()->json([
                'message' => 'Salary not found'
            ], 404);
        }

        $request->validate([
            'override' => 'nullable|numeric',
            'fine' => 'nullable|numeric',
        ]);

        $account = Account::findOrFail($salary->account_id);

        // 🔴 rollback old salary from account
        $account->price += $salary->total_salary;

        $override = $request->override ?? $salary->override;
        $fine = $request->fine ?? $salary->fine;

        $newTotal = $salary->base_salary + $override - $fine;

        // 🔴 check balance again
        if ($account->price < $newTotal) {
            return response()->json([
                'message' => 'Not enough balance after update'
            ], 400);
        }

        // 🔥 deduct new amount
        $account->price -= $newTotal;
        $account->save();

        $salary->update([
            'override' => $override,
            'fine' => $fine,
            'total_salary' => $newTotal,
        ]);

        return response()->json($salary);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $salary = Salary::find($id);

        if (!$salary) {
            return response()->json([
                'message' => 'Salary not found'
            ], 404);
        }

        $account = Account::findOrFail($salary->account_id);

        // 🔥 return money back to account
        $account->price += $salary->total_salary;
        $account->save();

        $salary->delete();

        return response()->json([
            'message' => 'Salary deleted successfully'
        ]);
    }
}