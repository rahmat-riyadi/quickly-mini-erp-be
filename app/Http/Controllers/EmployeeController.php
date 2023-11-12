<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = Employee::latest()->get();
            return DataTables::of($data)
                    ->addColumn('position', fn(Employee $employee) => $employee->position->name)
                    ->addIndexColumn()->make(true);
        }
    }

    public function destroy(Employee $employee, Request $request){
        try {
            $employee->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
