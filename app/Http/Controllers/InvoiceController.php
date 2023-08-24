<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class InvoiceController extends Controller
{
    public function index(){
        $data = Invoice::all();
        return ResponseController::create($data, true, 'get all sales item group successfully', 200);
    }

    public function store(Request $request){
        try {

            $reqToken = request()->header('Authorization');
            $token = PersonalAccessToken::findToken(substr($reqToken, 7));
            $data = Invoice::create(['counter_id' => $token->tokenable->counter_id, 'total_price' => $request->total_price]);
            foreach($request->items as $item){
                $data->salesItems()->attach([$item['id'] => [
                    'total' => $item['total'],
                    'quantity' => $item['quantity']
                ]]);
            }

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

    public function getSalesRecord(){
        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));
        $data = Invoice::where('counter_id', $token->tokenable->counter_id)->latest()->paginate(10);
        return ResponseController::create($data, true, 'get all sales record', 200);
    }

    public function getDetailSalesRecord($id){
        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));
        $data = Invoice::with('salesItems')
                        ->where('counter_id', $token->tokenable->counter_id)
                        ->where('id', $id)
                        ->latest()
                        ->first();
        return ResponseController::create($data, true, 'get all sales record', 200);
    }

}
