<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        return ProductType::all();
    }

    public function store(StoreProductTypeRequest $request)
    {
        return ProductType::create($request->validated());
    }

    public function update(UpdateProductTypeRequest $request, ProductType $productType)
    {
        $productType->update($request->validated());
        return $productType;
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();
        return response()->json(['message' => 'کاملا حذف شد']);
    }
}
