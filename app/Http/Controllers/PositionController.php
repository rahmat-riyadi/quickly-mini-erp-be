<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(){
        $data = Position::latest()->get();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = Position::create($request->all());
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

    public function update(Request $request, Position $position){
        try {
            $position->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($position, $status, $message, $code);
    }

    public function destroy(Position $position){
        try {
            $position->delete();
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
