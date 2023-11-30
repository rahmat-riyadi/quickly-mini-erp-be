<?php

namespace App\Http\Controllers;

use App\Models\WarehouseItemGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WarehouseItemGroupController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = WarehouseItemGroup::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(WarehouseItemGroup $warehouseItemGroup, Request $request){
        try {
            $warehouseItemGroup->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
