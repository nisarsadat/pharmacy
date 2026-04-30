<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Account;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['items.product', 'customer', 'account', 'warehouse'])
            ->latest()
            ->paginate(10);

        return SaleResource::collection($sales);
    }

    public function store(StoreSaleRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();
            $items = $data['items'];
            unset($data['items']);

            $total = 0;

            $sale = Sale::create($data);

            foreach ($items as $item) {

                $product = Product::findOrFail($item['product_id']);

                // ❌ check stock
                if ($product->product_quantity < $item['quantity']) {
                    throw new \Exception('Not enough stock');
                }

                $itemTotal = $item['quantity'] * $item['price'];
                $total += $itemTotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $itemTotal,
                ]);

                // 📉 decrease stock
                $product->decrement('product_quantity', $item['quantity']);
            }

            $discount = $data['discount'] ?? 0;
            $final = $total - $discount;
            $paid = $data['paid_amount'];
            $due = $final - $paid;

            $sale->update([
                'total_amount' => $total,
                'final_amount' => $final,
                'due_amount' => $due,
            ]);

            // 💰 account increase
            $account = Account::find($data['account_id']);
            $account->increment('price', $paid);

            DB::commit();

            return new SaleResource($sale->load(['items.product']));

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Sale $sale)
    {
        return new SaleResource(
            $sale->load(['items.product', 'customer', 'account', 'warehouse'])
        );
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
