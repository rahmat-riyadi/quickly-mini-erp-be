<?php

namespace App\Http\Controllers;

use App\Models\IncomingItem;
use Illuminate\Http\Request;

class IncomingItemController extends Controller
{
    public function index(){
        $data = IncomingItem::all();
        return ResponseController::create($data, true, 'get all incoming item successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = IncomingItem::create($request->all());
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

    public function update(Request $request, IncomingItem $incomingItem){
        try {
            $incomingItem->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($incomingItem, $status, $message, $code);
    }

    public function destroy(IncomingItem $incomingItem){
        try {
            $incomingItem->delete();
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
