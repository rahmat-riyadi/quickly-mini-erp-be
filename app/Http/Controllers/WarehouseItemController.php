<?php

namespace App\Http\Controllers;

use App\Models\WarehouseItem;
use Illuminate\Http\Request;

class WarehouseItemController extends Controller
{
    public function index(){

        $page = request()->query('page');

        if(is_null($page)){
            $data = WarehouseItem::with('warehouseItemGroup')->latest()->get();
        } else {
            $data = WarehouseItem::with('warehouseItemGroup')->latest()->paginate(10);
        }

        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = WarehouseItem::create($request->all());
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

    public function update(Request $request, WarehouseItem $warehouseItem){
        try {
            $warehouseItem->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($warehouseItem, $status, $message, $code);
    }

    public function destroy(WarehouseItem $warehouseItem){
        try {
            $warehouseItem->delete();
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
