<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SaleItemController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = SaleItem::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('price', fn(SaleItem $saleItem) => 'Rp '. number_format($saleItem->price))
                    ->addColumn('category', fn(SaleItem $saleItem) => $saleItem->category->name)
                    ->make(true);
        }
    }

    public function destroy(SaleItem $saleItem, Request $request){
        try {
            $saleItem->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
