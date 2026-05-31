<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Resources\WarehouseResource;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $warehouses = Warehouse::latest()->paginate($perPage);

        return response()->json([
            'items' => WarehouseResource::collection($warehouses->items()),
            'pagination' => [
                'total' => $warehouses->total(),
                'per_page' => $warehouses->perPage(),
                'current_page' => $warehouses->currentPage(),
                'last_page' => $warehouses->lastPage(),
                'from' => $warehouses->firstItem(),
                'to' => $warehouses->lastItem(),
            ]
        ]);
    }

    public function store(StoreWarehouseRequest $request)
    {
        $warehouse = Warehouse::create($request->validated());

        return new WarehouseResource($warehouse);
    }

    public function show(Warehouse $warehouse)
    {
        return new WarehouseResource($warehouse);
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());

        return new WarehouseResource($warehouse);
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return response()->json([
            'message' => 'Warehouse deleted successfully!'
        ]);
    }
}