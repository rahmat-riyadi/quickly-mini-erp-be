<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class WorkScheduleController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = WorkSchedule::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request){

        $data = [];

        foreach($request->schedules as $schedule){
            if(in_array(null, $schedule, true)){
                continue;
            }
            $data[] = $schedule;
        }

        if(count($data) == 0){
            throw new \Exception("Harap mengisi data terlebih dahulu");
        }

        DB::beginTransaction();

        try {
            
            foreach($data as $d){
                $employee = Employee::where('name', $d[1])->first('id');
                $counter = Counter::where('name', $d[2])->first('id');

                WorkSchedule::create([
                    'employee_id' => $employee->id,
                    'counter_id' => $counter->id,
                    'date' => Carbon::createFromFormat('d/m/Y',$d[0]),
                    'time_in' => $d[3],
                    'time_out' => $d[4],
                ]);

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

    public function update(Request $request){

        if(!is_array($request->schedules)){
            throw new \Exception("Harap mengisi data terlebih dahulu");
        }

        DB::beginTransaction();

        try {

            foreach($request->schedules as $schedule){

                if(empty($schedule[0])){
                    WorkSchedule::create([
                        'counter_id' => $schedule[1],
                        'employee_id' => $schedule[2],
                        'date' => Carbon::createFromFormat('d/m/Y',$schedule[3])->format('Y-m-d'),
                        'time_in' => $schedule[5],
                        'time_out' => $schedule[6],
                    ]);
                } else {
                    WorkSchedule::find($schedule[0])
                    ->update([
                        'counter_id' => $schedule[1],
                        'date' => Carbon::createFromFormat('d/m/Y',$schedule[3])->format('Y-m-d'),
                        'time_in' => $schedule[5],
                        'time_out' => $schedule[6],
                    ]);
                }

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
            WorkSchedule::find($id)->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
