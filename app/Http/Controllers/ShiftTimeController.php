<?php

namespace App\Http\Controllers;

use App\Models\ShiftTime;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShiftTimeController extends Controller
{
    public function index(Request $request,){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = ShiftTime::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function destroy(ShiftTime $shiftTime, Request $request){
        try {
            $shiftTime->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
