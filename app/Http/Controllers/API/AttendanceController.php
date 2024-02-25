<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MonthlySalaryController;
use App\Http\Resources\Attendance\CurrentStatusResource;
use App\Models\ShiftTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{


    public function changeStatus(Request $request){


        $currStatus = ucfirst($request->status);

        try {

            $attendance = $request->user()->attendance()
                    ->latest()
                    ->whereNull('attendance_time_out')
                    ->first();

            $attendance->update(['status' => $currStatus]);
                
            return $this->response(
                status: 200,
                success: true,
                message: 'Status berhasil diubah',
                data: new CurrentStatusResource($attendance) 
            );

        } catch (\Throwable $th) {
            return $this->response(
                status: 200,
                success: false,
                message: $th->getMessage(),
                data: null
            );
        }

    }

    public function getCurrentStatus(Request $request){
        
        $attendance = $request->user()->attendance()
                ->latest()
                ->whereNull('attendance_time_out')
                ->first();
            
        return $this->response(
            status: 200,
            success: $attendance ? true : false,
            message: 'get current status success',
            data: $attendance ? new CurrentStatusResource($attendance) : null
        );

    }

    public function store(Request $request){

        $employee = $request->user();
        
        $data = $request->all();

        $data['image'] = $request->file('image')->store('attendance');

        $workSchedule = $request->user()->currentWeekSchedule->where('date', Carbon::now()->format('Y-m-d'))->first();

        $entryDate = Carbon::parse($workSchedule->time_in);
        $latency = Carbon::now()->greaterThan($entryDate) ? $entryDate->diffInMinutes(Carbon::now()) : 0;
        $latencyMultiple = ceil($latency / 30);
        
        
        try {
            
            $data = $employee->attendance()->create([
                'image' => $data['image'],
                'attendance_time' => Carbon::now(),
                'location' => $data['location'],
                'description' => 'Hadir',
                'is_late' => !Carbon::now()->parse()->lessThanOrEqualTo($workSchedule->time_in),
                'deduction' => 15000 * $latencyMultiple,
                'status' => 'Sedang Bekerja'
            ]);

            $message = 'create data success';
            $status = true;
            $code = 200;

        } catch (\Throwable $th) {

            $code = 500;
            $message = $th->getMessage();
            $status = false;
        }

        return $this->response(
            status: $code,
            success: $status,
            message: $message,
            data: is_null($data) ? null : new CurrentStatusResource($data)
        );

    }

    public function timeOut(Request $request){

        $request->user()->attendance()
        ->latest()
        ->whereNull('attendance_time_out')
        ->first()
        ->update([
            'attendance_time_out' => Carbon::now(),
            'status' => 'Selesai Bekerja'
        ]);

        return $this->response(
            status: 200,
            success: true,
            message: 'status berhasil diubah',
            data: null
        );

    }


}
