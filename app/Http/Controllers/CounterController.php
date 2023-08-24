<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index(){
        $data = Counter::latest()->get();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function show(Counter $counter){
        return ResponseController::create($counter, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = Counter::create($request->all());
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

    public function update(Request $request, Counter $counter){
        try {
            $counter->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($counter, $status, $message, $code);
    }

    public function destroy(Counter $counter){
        try {
            $counter->delete();
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
