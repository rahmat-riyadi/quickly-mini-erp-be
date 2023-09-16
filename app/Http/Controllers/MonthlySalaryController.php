<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MonthlySalary;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlySalaryController extends Controller
{
    public function index(){
        $data = MonthlySalary::all();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public static function currentMonthSalary($employeeId){

        return MonthlySalary::where('employee_id', $employeeId)
                ->whereMonth('created_at', Carbon::now())
                ->whereYear('created_at', Carbon::now())
                ->exist();

    }

    public static function store(Employee $employee){

        $salaryDeduction = $employee->attendance->reduce(function($prev, $curr){
            return $prev + $curr->deduction;
        });

        $salary = Salary::latest()->where('employee_id', $employee->id)->first();

        $totalSalary = $salary->base_salary - $salaryDeduction;

        MonthlySalary::updateOrCreate(
            ['created_at' => Carbon::now(), 'employee_id' => $employee->id],
            [
                'employee_id' => $employee->id,
                'salary_deduction' => $salaryDeduction,
                'overtime_pay' => 0,
                'total_salary' => $totalSalary
            ]
        );

        try {
            $message = 'create data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return compact('status', 'message');
    }

    public static function update(Request $request, MonthlySalary $monthlySalary){
        try {
            $monthlySalary->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($monthlySalary, $status, $message, $code);
    }

    public function destroy(MonthlySalary $monthlySalary){
        try {
            $monthlySalary->delete();
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
}
