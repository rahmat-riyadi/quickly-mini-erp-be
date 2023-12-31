<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){

            $status = request()->query('params');

            $param = $request->query('generalSearch');

            Log::debug('adf');

            $url = env('APP_URL');

            $data = Employee::with('position')
            ->leftJoin('attendances', 'attendances.employee_id', '=', 'employees.id')
            ->where('employees.status', true)
            ->whereDate('attendances.created_at', Carbon::now())
            ->orderBy('attendances.created_at', 'DESC')
            ->select([
                'employees.id',
                'employees.name', 
                'employees.position_id', 
                DB::raw("CONCAT('$url/storage/', attendances.image) as image"), 
                'attendances.location', 
                'attendances.attendance_time', 
                'attendances.attendance_time_out', 
                'attendances.status', 
                'attendances.description', 
                'attendances.is_late'
            ])->get();

            Log::debug(json_decode($data));

            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(Attendance $attendance, Request $request){
        try {
            $attendance->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
