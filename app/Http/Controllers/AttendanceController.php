<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(){

        $data = Attendance::with('employee')->get();

        foreach($data as $item){
            // $item->image = env('APP_URL').'/public/storage/'. $item->image;
            $item->image = public_path('storage/'.$item->image);
        }

        return ResponseController::create($data, true, 'get all attendance successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = $request->all();
            $data['image'] = $request->file('image')->store('attendance');
            $data = Attendance::create($data);
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
            $data = Employee::where('username', $request->username)->first(['id', 'name']);
            return ResponseController::create($data, true, 'login successfully', 200);
        }
        return ResponseController::create(null, false, 'login failed', 200);

    }
}
