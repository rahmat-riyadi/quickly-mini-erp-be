<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MonthlySalary;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class MonthlySalaryController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');

            $data = Employee::leftJoin('monthly_salaries', function($join){
                $join->on('monthly_salaries.employee_id', 'employees.id')
                ->whereMonth('monthly_salaries.created_at', Carbon::now());
            })
            ->join('salaries', 'salaries.employee_id', 'employees.id')
            ->where('status', true)
            ->select(
                'employees.id',
                'employees.name',
                'salaries.base_salary',
                'monthly_salaries.salary_deduction',
                'monthly_salaries.total_salary'
            )
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('base_salary', fn($e) => 'Rp '. number_format($e->base_salary))
                    ->editColumn('salary_deduction', fn($e) => 'Rp '. number_format($e->salary_deduction))
                    ->editColumn('total_salary', fn($e) =>'Rp '.number_format($e->total_salary))
                    ->make(true);
        }
    }

    public static function store(Employee $employee){

        $salaryDeduction = $employee->attendance->reduce(function($prev, $curr){
            return $prev + $curr->deduction;
        });

        $salary = Salary::latest()->where('employee_id', $employee->id)->first();

        $totalSalary = $salary->base_salary - $salaryDeduction;

        $record = MonthlySalary::whereMonth('created_at', Carbon::now())
                        ->where('employee_id', $employee->id)
                        ->first();

        if($record){
            $record->update([
                'salary_deduction' => $salaryDeduction,
                'overtime_pay' => 0,
                'total_salary' => $totalSalary
            ]);
        } else {
            MonthlySalary::create([
                'employee_id' => $employee->id,
                'salary_deduction' => $salaryDeduction,
                'overtime_pay' => 0,
                'total_salary' => $totalSalary
            ]);
        }
        
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

    public function destroy(MonthlySalary $monthlySalary, Request $request){
        try {
            $monthlySalary->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
