<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function index(){
        $data = Lembur::all();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = Lembur::create($request->all());
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

    public function update(Request $request, Lembur $lembur){
        try {
            $lembur->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($lembur, $status, $message, $code);
    }

    public function destroy(Lembur $lembur){
        try {
            $lembur->delete();
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
