<?php

namespace App\Http\Controllers;

use App\Models\OwnerPickup;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Resources\OwnerPickupResource;
use App\Http\Requests\StoreOwnerPickupRequest;
use App\Http\Requests\UpdateOwnerPickupRequest;

class OwnerPickupController extends Controller
{
    /**
     * Display a paginated list
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $ownerPickups = OwnerPickup::with('account')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'items' => OwnerPickupResource::collection($ownerPickups->items()),
            'pagination' => [
                'total' => $ownerPickups->total(),
                'per_page' => $ownerPickups->perPage(),
                'current_page' => $ownerPickups->currentPage(),
                'last_page' => $ownerPickups->lastPage(),
                'from' => $ownerPickups->firstItem(),
                'to' => $ownerPickups->lastItem(),
            ]
        ]);
    }

    /**
     * Store new OwnerPickup
     */
    public function store(StoreOwnerPickupRequest $request)
    {
        $data = $request->validated();

        $account = Account::findOrFail($data['account_id']);

        if ($account->price < $data['amount']) {
            return response()->json([
                'message' => 'Not enough balance'
            ], 400);
        }

        // deduct
        $account->price -= $data['amount'];
        $account->save();

        $ownerPickup = OwnerPickup::create($data);

        return new OwnerPickupResource($ownerPickup->load('account'));
    }

    /**
     * Show single record
     */
    public function show(OwnerPickup $ownerPickup)
    {
        return new OwnerPickupResource($ownerPickup->load('account'));
    }

    /**
     * Update record
     */
    public function update(UpdateOwnerPickupRequest $request, OwnerPickup $ownerPickup)
    {
        $data = $request->validated();

        $account = $ownerPickup->account;

        // rollback old amount
        $account->price += $ownerPickup->amount;

        if ($account->price < $data['amount']) {
            return response()->json([
                'message' => 'Not enough balance'
            ], 400);
        }

        // deduct new amount
        $account->price -= $data['amount'];
        $account->save();

        $ownerPickup->update($data);

        return new OwnerPickupResource($ownerPickup->load('account'));
    }

    /**
     * Delete record
     */
    public function destroy(OwnerPickup $ownerPickup)
    {
        $account = $ownerPickup->account;

        // return money
        $account->price += $ownerPickup->amount;
        $account->save();

        $ownerPickup->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}