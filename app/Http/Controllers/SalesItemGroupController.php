<?php

namespace App\Http\Controllers;

use App\Models\SalesItemGroup;
use Illuminate\Http\Request;

class SalesItemGroupController extends Controller
{
    public function index(){

        $page = request()->query('page');

        if(is_null($page)){
            $data = SalesItemGroup::latest()->get();
        } else {
            $data = SalesItemGroup::latest()->paginate(10);
        }

        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){

        try {
            $data = SalesItemGroup::create($request->all());
            $message = 'data berhasil ditambah';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($data ?? [], $status, $message, $code);
    }

    public function update(Request $request, SalesItemGroup $salesItemGroup){
        try {
            $salesItemGroup->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($salesItemGroup, $status, $message, $code);
    }

    public function destroy(SalesItemGroup $salesItemGroup){
        try {
            $salesItemGroup->delete();
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
