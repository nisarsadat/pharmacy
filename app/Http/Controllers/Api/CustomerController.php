<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Facades\Storage;
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
    
        $customers = Customer::with('sales.loans')
            ->latest()
            ->paginate($perPage);
    
        return response()->json([
            'items' => CustomerResource::collection($customers->items()),
            'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
            ]
        ]);
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('customers', 'public');
        }

        $customer = Customer::create($data);

        return new CustomerResource($customer);
    }

    public function show(Customer $customer)
{
    $customer->load('sales'); // 👈 load sales here too

    return new CustomerResource($customer);
}


public function update(UpdateCustomerRequest $request, Customer $customer)
{
    $data = $request->validated();

    // اگر عکس جدید آمده باشد
    if ($request->hasFile('image')) {

        // حذف عکس قبلی اگر موجود باشد
        if ($customer->image && Storage::disk('public')->exists($customer->image)) {
            Storage::disk('public')->delete($customer->image);
        }

        // ذخیره عکس جدید
        $data['image'] = $request->file('image')->store('customers', 'public');
    }

    $customer->update($data);

    return new CustomerResource($customer);
}

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}