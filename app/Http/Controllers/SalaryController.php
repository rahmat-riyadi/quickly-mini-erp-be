<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = Salary::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request){

        $data = [];

        foreach($request->salaries as $salary){
            if($salary[2] == null){
                continue;
            }
            $data[] = $salary;
        }

        if(count($data) == 0){
            throw new \Exception("Harap mengisi data terlebih dahulu");
        }        

        DB::beginTransaction();

        try {
            
            foreach($data as $d){

                Salary::updateOrCreate(
                    ['id' => $d[0]],
                    [
                        'employee_id' => $d[1],
                        'base_salary' => $d[2],
                        'attendance_intensive' => $d[3],
                        'split' => $d[4],
                        'transport' => $d[5],
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
            ]);

        } catch (\Throwable $th) {

            DB::rollBack();
            throw $th;

        }

    }

    public function destroy($id){

        if($id == 0) return;

        try {
            Salary::find($id)->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
