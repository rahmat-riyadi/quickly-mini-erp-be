<?php

namespace App\Http\Controllers;

use App\Models\SaleItemGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SaleItemGroupController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = SaleItemGroup::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(SaleItemGroup $saleItemGroup, Request $request){
        try {
            $saleItemGroup->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
