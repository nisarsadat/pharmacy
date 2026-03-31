<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

class AccountController extends Controller
{
    /**
     * Display a paginated list of accounts
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $accounts = Account::latest()->paginate($perPage);

        return response()->json([
            'items' => AccountResource::collection($accounts->items()),
            'pagination' => [
                'total' => $accounts->total(),
                'per_page' => $accounts->perPage(),
                'current_page' => $accounts->currentPage(),
                'last_page' => $accounts->lastPage(),
                'from' => $accounts->firstItem(),
                'to' => $accounts->lastItem(),
            ]
        ]);
    }

    /**
     * Store a new account
     */
    public function store(StoreAccountRequest $request)
    {
        $account = Account::create($request->validated());

        return new AccountResource($account);
    }

    /**
     * Display a single account
     */
    public function show(Account $account)
    {
        return new AccountResource($account);
    }

    /**
     * Update an account
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * Delete an account
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return response()->json([
            'message' => 'موفقانه اکونت دلیت شد!'
        ]);
    }
}