<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $sales = Sale::with('items')->paginate($perPage);

        return SaleResource::collection($sales);
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = Sale::create($request->validated());

        foreach ($request->items as $item) {
            $sale->items()->create($item);
        }

        return new SaleResource($sale->load('items'));
    }

    public function show($id)
    {
        $sale = Sale::with('items')->findOrFail($id);

        return new SaleResource($sale);
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $sale->update($request->validated());

        return new SaleResource($sale);
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
} 
