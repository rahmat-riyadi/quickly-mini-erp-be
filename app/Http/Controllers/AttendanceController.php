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

            $data = Employee::with('position')->leftJoin('attendances', function($join)  {
                $join->on('employees.id', '=', 'attendances.employee_id')
                ->join('shift_times', 'shift_times.id', '=', 'attendances.shift_time_id',)
                ->whereDate('attendances.created_at', '=', Carbon::now());
            })
            ->where('employees.status', true)
            // ->when($status != 'all' && $status != 'belum absen', function($query) use ($status){
            //     $query->where('attendances.description', '=', $status);
            // })
            // ->when($status == 'belum absen', function($query){
            //     $query->whereNull('attendances.description');
            // })
            ->orderBy('attendances.created_at', 'DESC')
            ->select([
                'employees.id',
                'employees.name', 
                'employees.position_id', 
                DB::raw("CONCAT('$url/storage/', attendances.image) as image"), 
                'attendances.location', 
                'attendances.attendance_time', 
                'attendances.status', 
                'attendances.description', 
                'shift_times.name as shift', 
                'shift_times.from as entry_time',
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
