<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $data = Supplier::latest()->get();
            Log::debug($data);
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function destroy(Supplier $supplier, Request $request){
        try {
            $supplier->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
