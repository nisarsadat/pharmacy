<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductImage; // 👈 مهم
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with(['warehouse', 'productType', 'images'])->get();
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        // ✅ آپلود عکس
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path
            ]);
        }

        return response()->json([
            'message' => 'Product created',
            'data' => $product->load('images')
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        // ✅ آپلود عکس جدید
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path
            ]);
        }

        return response()->json([
            'message' => 'Product updated',
            'data' => $product->load('images')
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Deleted']);
    }
}