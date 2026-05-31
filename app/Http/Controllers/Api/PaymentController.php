<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {

            $sale = Sale::findOrFail($data['sale_id']);
            $account = Account::findOrFail($data['account_id']);

            // 1. Create Payment
            $payment = Payment::create([
                'sale_id' => $sale->id,
                'customer_id' => $sale->customer_id,
                'account_id' => $account->id,
                'amount' => $data['amount'],
                'date' => $data['date'],
                'note' => $data['note'] ?? null,
            ]);

            // 2. Update Sale
            $sale->paid_amount += $data['amount'];
            $sale->due_amount -= $data['amount'];
            $sale->save();

            // 3. Add money to Account
            $account->price += $data['amount'];
            $account->save();

        });

        return response()->json([
            'message' => 'Payment successful'
        ]);
    }
}