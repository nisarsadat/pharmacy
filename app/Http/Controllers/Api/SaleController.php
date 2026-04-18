<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // =======================
    // INDEX (WITH PAGINATION)
    // =======================
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $sales = Sale::with('items')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'items' => SaleResource::collection($sales->items()),
            'pagination' => [
                'total' => $sales->total(),
                'per_page' => $sales->perPage(),
                'current_page' => $sales->currentPage(),
                'last_page' => $sales->lastPage(),
                'from' => $sales->firstItem(),
                'to' => $sales->lastItem(),
            ]
        ]);
    }

    // =======================
    // STORE (FIXED VERSION)
    // =======================
    public function store(StoreSaleRequest $request)
{
    DB::beginTransaction();

    try {

        $data = $request->validated();

        $items = $data['items'];
        unset($data['items']);

        $sale = Sale::create($data);

        foreach ($items as $item) {

            // 1. پیدا کردن محصول
            $product = \App\Models\Product::findOrFail($item['product_id']);

            // 2. چک کردن stock (اختیاری ولی مهم)
            if ($product->product_amount < $item['quantity']) {
                throw new \Exception("Not enough stock for product: " . $product->name);
            }

            // 3. ساخت sale item
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'total'      => $item['total'],

                'main_price_per_carton' => $item['main_price_per_carton'] ?? null,
                'main_price_per_quantity' => $item['main_price_per_quantity'] ?? null,
                'total_price_per_carton' => $item['total_price_per_carton'] ?? null,
                'total_price_per_quantity' => $item['total_price_per_quantity'] ?? null,
                'quantity_product_amount' => $item['quantity_product_amount'] ?? null,
                'quantity_per_carton' => $item['quantity_per_carton'] ?? null,
            ]);

            // 4. کم کردن stock 🔥
            $product->product_amount -= $item['quantity'];
            $product->save();
        }

        DB::commit();

        return new SaleResource($sale->load('items'));

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Sale creation failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // =======================
    // SHOW
    // =======================
    public function show($id)
    {
        $sale = Sale::with('items')->findOrFail($id);

        return new SaleResource($sale);
    }

    // =======================
    // UPDATE
    // =======================
    public function update(UpdateSaleRequest $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $sale->update($request->validated());

        return new SaleResource($sale->load('items'));
    }

    // =======================
    // DELETE
    // =======================
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return response()->json([
            'message' => 'Sale deleted successfully'
        ]);
    }
}