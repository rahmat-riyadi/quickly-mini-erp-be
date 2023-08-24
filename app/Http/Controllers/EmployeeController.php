<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $data = Employee::latest()->paginate(10);
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){

        try {

            // if(isset($request->image)){
            //     $image = $request->file('image')->store('image/employee');
            //     $data = Employee::create([...$request->all(), 'image' => $image]);
            // } else {
            // }
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
}
