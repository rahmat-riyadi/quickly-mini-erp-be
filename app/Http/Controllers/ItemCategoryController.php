<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ItemCategoryController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = ItemCategory::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(ItemCategory $itemCategory, Request $request){
        try {
            $itemCategory->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
