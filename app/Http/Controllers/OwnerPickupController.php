<?php

namespace App\Http\Controllers;

use App\Models\OwnerPickup;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOwnerPickupRequest;
use App\Http\Requests\UpdateOwnerPickupRequest;

class OwnerPickupController extends Controller
{
    public function index()
    {
        return OwnerPickup::with('account')->paginate(10);
    }

    public function store(StoreOwnerPickupRequest $request)
    {
        $data = OwnerPickup::create($request->validated());
        return response()->json($data, 201);
    }

    public function show(OwnerPickup $ownerPickup)
    {
        return $ownerPickup->load('account');
    }

    public function update(UpdateOwnerPickupRequest $request, OwnerPickup $ownerPickup)
    {
        $ownerPickup->update($request->validated());
        return response()->json($ownerPickup);
    }

    public function destroy(OwnerPickup $ownerPickup)
    {
        $ownerPickup->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}