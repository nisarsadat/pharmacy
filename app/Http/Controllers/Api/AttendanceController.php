<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Resources\AttendanceResource;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\BulkAttendanceRequest;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        $data = Attendance::with('employee')
            ->latest()
            ->paginate($perPage);

        return AttendanceResource::collection($data);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->validated();

        // تبدیل شمسی → میلادی
        $data['date'] = Jalalian::fromFormat('Y-m-d', $data['date'])->toCarbon();

        // ✅ کنترول نهایی (خیلی مهم)
        if ($data['status'] !== 'present') {
            $data['check_in'] = null;
            $data['check_out'] = null;
        }

        $attendance = Attendance::create($data);

        return new AttendanceResource($attendance);
    }

    public function show(Attendance $attendance)
    {
        return new AttendanceResource(
            $attendance->load('employee')
        );
    }

    public function update(StoreAttendanceRequest $request, Attendance $attendance)
    {
        $data = $request->validated();

        // تبدیل تاریخ
        $data['date'] = Jalalian::fromFormat('Y-m-d', $data['date'])->toCarbon();

        // ✅ حل کامل مشکل تو
        if ($data['status'] !== 'present') {
            $data['check_in'] = null;
            $data['check_out'] = null;
        } else {
            // اگر present بود ولی ساعت نیامده
            $data['check_in'] = $data['check_in'] ?? null;
            $data['check_out'] = $data['check_out'] ?? null;
        }

        $attendance->update($data);

        return new AttendanceResource($attendance);
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
    public function bulkStore(BulkAttendanceRequest $request)
{
    $records = $request->validated()['attendances'];

    $insertData = [];

    foreach ($records as $item) {

        // تبدیل تاریخ شمسی → میلادی
        $date = Jalalian::fromFormat('Y-m-d', $item['date'])->toCarbon();

        // اگر حاضر نبود، ساعت‌ها null
        if ($item['status'] !== 'present') {
            $item['check_in'] = null;
            $item['check_out'] = null;
        }

        $insertData[] = [
            'employee_id' => $item['employee_id'],
            'date' => $date,
            'status' => $item['status'],
            'check_in' => $item['check_in'] ?? null,
            'check_out' => $item['check_out'] ?? null,
            'note' => $item['note'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // جلوگیری از duplicate (اختیاری ولی مهم)
    foreach ($insertData as $data) {
        Attendance::updateOrCreate(
            [
                'employee_id' => $data['employee_id'],
                'date' => $data['date'],
            ],
            $data
        );
    }

    return response()->json([
        'message' => 'Bulk attendance saved successfully'
    ]);
}
}