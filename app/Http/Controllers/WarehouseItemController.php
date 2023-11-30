<?php

namespace App\Http\Controllers;

use App\Models\WarehouseItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WarehouseItemController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = WarehouseItem::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('sale_price', fn(WarehouseItem $warehouseItem) => 'Rp '. number_format($warehouseItem->sale_price))
                    ->editColumn('buy_price', fn(WarehouseItem $warehouseItem) => 'Rp '. number_format($warehouseItem->buy_price))
                    ->addColumn('category', fn(WarehouseItem $warehouseItem) => $warehouseItem->category->name)
                    ->make(true);
        }
    }

    public function destroy(WarehouseItem $warehouseItem, Request $request){
        try {
            $warehouseItem->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
