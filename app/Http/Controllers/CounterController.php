<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CounterController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $param = $request->query('generalSearch');
            $data = Counter::select('*')->latest();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
    }

    public function getAllCounter(Request $request){

        $q = $request->name;

        $data = Counter::where('name', 'LIKE', "%{$request->name}%")->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function destroy(Counter $counter, Request $request){
        try {
            $counter->delete();
            $status = true;
            $message = 'data berhasil dihapus';
        } catch (\Exception $e){
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
