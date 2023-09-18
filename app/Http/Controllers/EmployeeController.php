<?php

namespace App\Http\Controllers;

use App\Http\Resources\Attendance\CurrentMonthAttendanceResource;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\MonthlySalary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

        $status = request()->query('status');

        $data = Employee::with('position')
                ->when($status != 'all', function($q) use ($status) {
                    $q->where('status', $status);
                })
                ->select('id','name', 'position_id', 'phone', 'status', 'entry_date')
                ->latest()
                ->paginate(10);
        return ResponseController::create($data, true, 'get employee successfully', 200);
    }

    public function show(Employee $employee){
        return ResponseController::create($employee, true, 'get detail employee successfully', 200);
    }

    public function store(Request $request){

        try {
            $data = Employee::create([...$request->all(), 'image' => null]);
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

    public function update(Request $request, Employee $employee){
        try {
            $employee->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($employee, $status, $message, $code);
    }

    public function destroy(Employee $employee){
        try {
            $employee->delete();
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

    public function getEmployeeTodayAttendance(){

        // $data = Employee::with('attendance')->get();
        $status = request()->query('status');

        $data = Employee::with('position')->leftJoin('attendances', function($join) use ($status) {
            $join->on('employees.id', '=', 'attendances.employee_id')
            ->join('shift_times', 'shift_times.id', '=', 'attendances.shift_time_id',)
            ->whereDate('attendances.created_at', '=', Carbon::now());
        })
        ->where('status', true)
        ->when($status != 'all' && $status != 'belum absen', function($query) use ($status){
            $query->where('attendances.description', '=', $status);
        })
        ->when($status == 'belum absen', function($query){
            $query->whereNull('attendances.description');
        })
        ->orderBy('attendances.created_at', 'DESC')
        ->select([
            'employees.id',
            'employees.name', 
            'employees.position_id', 
            'attendances.image', 
            'attendances.location', 
            'attendances.attendance_time', 
            'attendances.description', 
            'shift_times.name as shift', 
            'shift_times.from as entry_time',
            'attendances.is_late'
        ])
        ->paginate(10);

        return ResponseController::create($data, true, 'get all attendance', 200);

    }

    public function getDetailAttendance($id){
        
        $employee = Employee::with('position')
                    ->join('attendances', function($join){
                        $join->on('employees.id', '=', 'attendances.employee_id')
                        ->join('shift_times', 'shift_times.id', '=', 'attendances.shift_time_id',)
                        ->whereDate('attendances.created_at', '=', Carbon::now());
                    })
                    ->select(
                        'employees.name',
                        'employees.position_id',
                        'attendances.attendance_time',
                        'attendances.location',
                        'attendances.deduction',
                        'attendances.image',
                        'shift_times.name as shift',
                        'shift_times.from as entry_date',
                        'shift_times.until as exit_date',
                    )
                    ->find($id);

        $entryDate = Carbon::parse($employee->entry_date);
        $attendanceTime = Carbon::parse($employee->attendance_time);
        $diff = $attendanceTime->greaterThan($entryDate) ? $entryDate->diff($attendanceTime)->format('%H:%I:%S') : 0;
        $employee->late = $diff;

        $employee->image = url("storage/$employee->image");

        return ResponseController::create($employee, true, 'get all attendance', 200);

    }

    public function getAllEmployeeCurrentSalary(){

        $data = Employee::with('position')
        ->leftJoin('monthly_salaries', function($join){
            $join->on('employees.id', '=', 'monthly_salaries.employee_id')
            ->whereMonth('monthly_salaries.created_at', '=', Carbon::now());
        })
        ->leftJoin('salaries', 'salaries.employee_id', '=', 'employees.id')
        ->where('status', true)
        ->orderBy('employees.name', 'ASC')
        ->select([
            'employees.id',
            'employees.name', 
            'employees.position_id', 
            'monthly_salaries.total_salary',
            'salaries.base_salary'
        ])
        ->paginate(10);

        return ResponseController::create($data, true, 'get all current month salary', 200);

    }

    public function updateEmployeeFromMobile(Request $request, Employee $employee){
        try {
            $employee->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($employee, $status, $message, $code);
    }

    public function getEmployeeDetailCurrentSalary(Employee $employee){

        $currentAttendances = Attendance::with('shift')
                                        ->where('employee_id', $employee->id)
                                        ->whereMonth('created_at', Carbon::now())
                                        ->get();
        
        $totalSalary = MonthlySalary::where('employee_id', $employee->id)
                    ->whereMonth('created_at', Carbon::now())
                    ->first([
                        'salary_deduction',
                        'overtime_pay',
                        'total_salary',
                    ]);

        $data = Employee::with('position')
        ->leftJoin('salaries', function($join){
            $join->on('employees.id', '=', 'salaries.employee_id')
            ->latest()
            ->limit(1);
        })
        ->where('status', true)
        ->where('employees.id', $employee->id)
        ->first([
            'employees.id',
            'employees.name', 
            'employees.position_id', 
            'salaries.base_salary',
            'salaries.time_off',
            'attendance_intensive'
        ]);

        return ResponseController::create([
            'employee' => $data,
            'attendance_list' => CurrentMonthAttendanceResource::collection($currentAttendances),
            'total_salary' => $totalSalary
        ], true, 'get employee detail salary', 200);
        
    }


}
