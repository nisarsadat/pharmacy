<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanPaymentRequest;
use App\Http\Resources\LoanPaymentResource;
use App\Models\Account;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanPaymentController extends Controller
{
    public function store(StoreLoanPaymentRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();

            $loan = LoanController::findOrFail($data['loan_id']);

            // create payment
            $payment = LoanPayment::create($data);

            // update loan
            $loan->paid_amount += $data['amount'];
            $loan->remaining_amount -= $data['amount'];
            $loan->save();

            // increase account money
            $account = Account::find($data['account_id']);
            $account->increment('price', $data['amount']);

            DB::commit();

            return new LoanPaymentResource($payment);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function index()
    {
        return LoanPaymentResource::collection(
            LoanPayment::with(['loan', 'account'])->latest()->paginate(10)
        );
    }
}
