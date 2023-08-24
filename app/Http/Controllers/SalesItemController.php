<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    public function index(){

        $page = request()->query('page');

        if(is_null($page)){
            $data = SalesItem::with('salesItemGroup')->latest()->get();
        } else {
            $data = SalesItem::with('salesItemGroup')->latest()->paginate(10);
        }

        return ResponseController::create($data, true, 'get all sales item successfully', 200);
    }

    public function store(Request $request){

        $data = $request->all();

        $data['is_use_cup'] = isset($request->is_use_cup);

        try {
            $data = SalesItem::create($data);
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

    public function update(Request $request, SalesItem $salesItem){
        try {
            $salesItem->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($salesItem, $status, $message, $code);
    }

    public function destroy(SalesItem $salesItem){
        try {
            $salesItem->delete();
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
