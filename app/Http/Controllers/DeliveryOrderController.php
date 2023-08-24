<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class DeliveryOrderController extends Controller
{
    public function index(){
        $data = DeliveryOrder::with('counter')->latest()->paginate(10);
        return ResponseController::create($data, true, 'get all DO successfully', 200);
    }

    public function show(DeliveryOrder $deliveryOrder){
        $items = DB::table('delivery_order_items')
                    ->where('delivery_order_id', $deliveryOrder->id)
                    ->when($deliveryOrder->items_type == 'w' || $deliveryOrder->items_type == 'p'  , function($q){
                        $q->join('warehouse_items', 'warehouse_items.id', '=', 'delivery_order_items.item_id');
                    })
                    ->get([
                        'delivery_order_items.id',
                        'delivery_order_items.item_id',
                        'warehouse_items.name',
                        'warehouse_items.unit',
                        'delivery_order_items.quantity',
                    ]);
        $deliveryOrder->items = $items;
        $deliveryOrder->counter = $deliveryOrder->counter();
        return ResponseController::create($deliveryOrder, true, 'get all DO successfully', 200);
    }

    public function counterDeliveryOrder(){
        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));
        $data = DeliveryOrder::where('counter_id', $token->tokenable->counter_id)->latest()->get();
        return ResponseController::create($data, true, 'get all DO successfully', 200);
    }

    public function storeDO(Request $request){
        try {

            $reqToken = request()->header('Authorization');
            $token = PersonalAccessToken::findToken(substr($reqToken, 7));
            $counter = Counter::find($token->tokenable->counter_id);
            $deliveryTypeCode = $request->delivery_type == 'Pagi ' ? 'PG' : 'SR';
            $counterDOCount = DeliveryOrder::where('created_at', Carbon::now())->where('counter_id', $counter->id)->count();

            $doNumber = Carbon::now()->format('Ymd').'/'.$counter->code.'/'.$deliveryTypeCode.'/'.($counterDOCount+1);
            $data = DeliveryOrder::create([...$request->all(), 'do_number' => $doNumber]);
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

    public function storeDOItems(Request $request){

        try {

            DB::table('delivery_order_items')->insert([
                'delivery_order_id' => $request->delivery_order_id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $data = DB::table('delivery_order_items')
                    ->where('delivery_order_items.created_at', Carbon::now())
                    ->where('delivery_order_items.delivery_order_id', $request->delivery_order_id)
                    ->join('warehouse_items', 'warehouse_items.id', '=', 'delivery_order_items.item_id')
                    ->first([
                        'delivery_order_items.id',
                        'warehouse_items.name',
                        'delivery_order_items.quantity',
                        'warehouse_items.unit',
                    ]);

            $message = 'Add DO Item Success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($data ?? [], $status, $message, $code);

    }

    public function store(Request $request){
        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));
        $counter = Counter::find($token->tokenable->counter_id);
        $deliveryTypeCode = $request->delivery_type == 'Pagi ' ? 'PG' : 'SR';
        $counterDOCount = DeliveryOrder::where('created_at', Carbon::now())->where('counter_id', $counter->id)->count();
        $doNumber = Carbon::now()->format('Ymd').'/'.$counter->code.'/'.$deliveryTypeCode.'/'.($counterDOCount+1);
        try {

            $data = DeliveryOrder::create([
                'request_date' => Carbon::now(),
                'request_time' => Carbon::now(),
                'counter_id' => $token->tokenable->counter_id,
                'items_type' => $request->items_type,
                'do_number' => $doNumber,
                'delivery_type' => $request->delivery_type
            ]);

            foreach(json_decode($request->items) as $item){
                DB::table('delivery_order_items')->insert([
                    'delivery_order_id' => $data->id,
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                ]);
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

    public function update(Request $request, DeliveryOrder $deliveryOrder){
        try {
            $deliveryOrder->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($deliveryOrder, $status, $message, $code);
    }

    public function updateDOItems(Request $request){
        try {

            DB::table('delivery_order_items')->where('id', $request->id)->update([
                'item_id' => $request->item_id,
                'quantity' => $request->quantity
            ]);

            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create(null, $status, $message, $code);
    }

    public function destroy(DeliveryOrder $deliveryOrder){
        try {
            $deliveryOrder->delete();
            $message = 'delete data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create(null, $status, $message, $code);
    }

    public function destroyDeliveryItems($id){
        try {
            $data = DB::table('delivery_order_items')->where('id',$id)->delete();
            $message = 'delete data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($id, $status, $message, $code);
    }
}
