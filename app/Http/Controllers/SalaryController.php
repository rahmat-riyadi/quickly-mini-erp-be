<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Employee $employee){
        // $data = $employee->salaries;
        $data = [
            'id' => $employee->id,
            'name' => $employee->name,
            'position' => $employee->position->name,
            'salaries' => $employee->salaries
        ];
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request, Employee $employee){
        try {
            $employee->salaries()->create($request->all());
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

    public function update(Request $request, Salary $salary){
        try {
            $salary->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($salary, $status, $message, $code);
    }

    public function destroy(Salary $salary){
        try {
            $salary->delete();
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
