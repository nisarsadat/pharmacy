<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return LoanResource::collection(
            Loan::with(['customer', 'sale'])->latest()->paginate(10)
        );
    }

    public function store(StoreLoanRequest $request)
    {
        $loan = Loan::create($request->validated());

        return new LoanResource($loan);
    }

    public function show(Loan $loan)
    {
        return new LoanResource($loan->load(['customer', 'sale', 'payments']));
    }

    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $loan->update($request->validated());

        return new LoanResource($loan);
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response()->json(['message' => 'Loan deleted']);
    }
}
