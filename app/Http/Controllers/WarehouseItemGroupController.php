<?php

namespace App\Http\Controllers;

use App\Models\WarehouseItemGroup;
use Illuminate\Http\Request;

class WarehouseItemGroupController extends Controller
{
    public function index(){

        $page = request()->query('page');

        if(is_null($page)){
            $data = WarehouseItemGroup::latest()->get();
        } else {
            $data = WarehouseItemGroup::latest()->paginate(10);
        }

        return ResponseController::create($data, true, 'get all warehouse item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = WarehouseItemGroup::create($request->all());
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

    public function update(Request $request, WarehouseItemGroup $warehouseItemGroup){
        try {
            $warehouseItemGroup->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($warehouseItemGroup, $status, $message, $code);
    }

    public function destroy(WarehouseItemGroup $warehouseItemGroup){
        try {
            $warehouseItemGroup->delete();
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
