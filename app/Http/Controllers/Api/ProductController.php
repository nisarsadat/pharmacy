<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $products = Product::with(['warehouse', 'productType'])
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'items' => ProductResource::collection($products->items()),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
    
        // store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
    
                $path = $image->store('products', 'public');
    
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }
    
        return new ProductResource($product->load('images'));
    }

    public function show(Product $product)
    {
        $product->load(['warehouse', 'productType']);

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
    
        if ($request->hasFile('images')) {
    
            // delete old images (optional)
            foreach ($product->images as $img) {
                \Storage::disk('public')->delete($img->image);
                $img->delete();
            }
    
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
    
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }
    
        return new ProductResource($product->load('images'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'محصول موفقانه حذف شد'
        ]);
    }
}