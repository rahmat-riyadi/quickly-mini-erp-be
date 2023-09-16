<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\ShiftTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(){
        $data = Attendance::all();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){

        $employee = Employee::find($request->employee_id);
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
                'deduction' => 15000 * $latencyMultiple
            ]);

            MonthlySalaryController::store($employee);

            $message = 'create data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return ResponseController::create($data ?? [], $status, $message, $code);
    }


    public function update(Request $request, Attendance $attendance){
        try {
            $attendance->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($attendance, $status, $message, $code);
    }

    public function destroy(Attendance $attendance){
        try {
            $attendance->delete();
            $message = 'delete data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create(null, $status, $message, $code);
    }

    public function login(Request $request){

        if(Auth::guard('employee')->attempt(['username' => $request->username, 'password' => $request->password])){
            $data = Employee::whereUsername($request->username)->first(['id','name', 'username']);
            return ResponseController::create($data, true, 'login success', 200);

        }

        return ResponseController::create('username atau password salah', false, 'unauthorized', 401);

    }


}
