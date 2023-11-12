<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MonthlySalaryController;
use App\Models\ShiftTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request){

        $employee = $request->user();
        
        $shift = ShiftTime::find($request->shift_time_id);
        $data = $request->all();

        $data['image'] = $request->file('image')->store('attendance');

        $entryDate = Carbon::parse($shift->from);
        $latency = Carbon::now()->greaterThan($entryDate) ? $entryDate->diffInMinutes(Carbon::now()) : 0;
        $latencyMultiple = ceil($latency / 30);
        
        
        try {
            
            $employee->attendance()->create([
                'image' => $data['image'],
                'attendance_time' => Carbon::now(),
                'location' => $data['location'],
                'description' => 'Hadir',
                'is_late' => !Carbon::now()->parse()->lessThanOrEqualTo($shift->from),
                'shift_time_id' => $data['shift_time_id'],
                'deduction' => 15000 * $latencyMultiple,
                'status' => 'Sedang Bekerja'
            ]);

            MonthlySalaryController::store($employee);

            $message = 'create data success';
            $status = true;
            $code = 200;

        } catch (\Throwable $th) {

            $code = 500;
            $message = $th->getMessage();
            $status = false;
        }


        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => null
        ], $code);

    }
}
