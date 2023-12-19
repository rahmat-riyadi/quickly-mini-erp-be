<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = Item::with('category')->latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(Item $item, Request $request){
        try {
            $item->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
