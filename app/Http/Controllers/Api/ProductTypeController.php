<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Resources\ProductTypeResource;
use App\Http\Requests\StoreProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;

class ProductTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $productTypes = ProductType::latest()->paginate($perPage);

        return response()->json([
            'items' => ProductTypeResource::collection($productTypes->items()),
            'pagination' => [
                'total' => $productTypes->total(),
                'per_page' => $productTypes->perPage(),
                'current_page' => $productTypes->currentPage(),
                'last_page' => $productTypes->lastPage(),
                'from' => $productTypes->firstItem(),
                'to' => $productTypes->lastItem(),
            ]
        ]);
    }

    public function store(StoreProductTypeRequest $request)
    {
        $productType = ProductType::create($request->validated());

        return new ProductTypeResource($productType);
    }

    public function show(ProductType $productType)
    {
        return new ProductTypeResource($productType);
    }

    public function update(UpdateProductTypeRequest $request, ProductType $productType)
    {
        $productType->update($request->validated());

        return new ProductTypeResource($productType);
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return response()->json([
            'message' => 'Product Type deleted successfully!'
        ]);
    }
}