<?php

namespace App\Http\Controllers;

use App\Models\ShiftTime;
use Illuminate\Http\Request;

class ShiftTimeController extends Controller
{
    public function index(){
        $data = ShiftTime::all();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = ShiftTime::create($request->all());
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

    public function update(Request $request, ShiftTime $shiftTime){
        try {
            $shiftTime->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($shiftTime, $status, $message, $code);
    }

    public function destroy(ShiftTime $shiftTime){
        try {
            $shiftTime->delete();
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
