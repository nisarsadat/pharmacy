<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
{
    $perPage = (int) $request->get('per_page', 10);

    $employees = Employee::withCount([
        // شمارش present
        'attendances as total_present' => function ($q) {
            $q->where('status', 'present');
        },

        // شمارش absent
        'attendances as total_absent' => function ($q) {
            $q->where('status', 'absent');
        },

        // شمارش leave
        'attendances as total_leave' => function ($q) {
            $q->where('status', 'leave');
        },
    ])
    ->latest()
    ->paginate($perPage);

    return EmployeeResource::collection($employees);
}

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        // upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees', 'public');
        }

        // auto calculate salary
        $data['salary_amount'] = $data['salary_amount_per_day'] * $data['work_days'];

        $employee = Employee::create($data);

        return new EmployeeResource($employee);
    }

    public function show(Employee $employee)
{
    $employee->loadCount([
        'attendances as total_present' => function ($q) {
            $q->where('status', 'present');
        },
        'attendances as total_absent' => function ($q) {
            $q->where('status', 'absent');
        },
        'attendances as total_leave' => function ($q) {
            $q->where('status', 'leave');
        },
    ]);

    return new EmployeeResource($employee);
}

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees', 'public');
        }

        // recalculate salary
        $data['salary_amount'] = $data['salary_amount_per_day'] * $data['work_days'];

        $employee->update($data);

        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}