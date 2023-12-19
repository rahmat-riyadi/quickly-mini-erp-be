<?php

namespace App\Livewire\Forms;

use App\Events\SendDoNotification;
use App\Models\CounterItem;
use App\Models\DeliveryOrder;
use App\Models\Item;
use App\Models\User;
use App\Notifications\DeliveryOrder as NotificationsDeliveryOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Rule;
use Livewire\Form;

class DeliveryOrderForm extends Form
{

    public function __construct()
    {
        $this->order_date = Carbon::now()->format('Y-m-d');
        $this->order_time = Carbon::now()->format('H:i');
        $this->counter_id = auth()->user()->counter->id ?? null;
    }

    public ?DeliveryOrder $deliveryOrder;

    #[Rule('required', message: 'Nomor DO harus diisi')]
    public $do_number;

    #[Rule('required', message: 'Counter harus diisi')]
    public $counter_id;

    #[Rule('required', message: 'Tanggal pengiriman harus diisi')]
    public $delivery_date;

    #[Rule('required', message: 'Waktu pengiriman harus diisi')]
    public $delivery_time;

    #[Rule('required', message: 'Tanggal order harus diisi')]
    public $order_date;

    #[Rule('required', message: 'Waktu order harus diisi')]
    public $order_time;

    #[Rule('required', message: 'Item DO harus diisi')]
    public $items = [];

    public function setModel(DeliveryOrder $deliveryOrder){
        $this->deliveryOrder = $deliveryOrder;
        $this->fill($deliveryOrder);
    }

    public function addItem($id, $quantity){

        $item = Item::find($id);

        array_push($this->items,[
            'id' => $item->id,
            'name' => $item->name . ' - ' . $item->unit,
            'quantity' => $quantity,
        ]);
    }

    public function removeItem($idx){
        array_splice($this->items, $idx, 1);
    }

    public function changeQuantity($idx, $val){
        $this->items[$idx]['quantity'] = $val;
    }

    public function store(){

        DB::beginTransaction();

        try {
            
            $do = DeliveryOrder::create([
                'counter_id' => $this->counter_id,
                'order_date' => $this->order_date,
                'order_time' => $this->order_time,
                'do_number' => rand(1,1000)
            ]);

            foreach($this->items as $item){
                $do->items()->create([
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'status' => false,
                    'quantity_recieved' => 0
                ]);
            }


            DB::commit();

            $user = User::role('operational')->get();

            Notification::send($user, new NotificationsDeliveryOrder($do));
            SendDoNotification::dispatch();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }

    }

    public function update(){
        $this->deliveryOrder->update($this->all());
    }

    public function changeDoStatus($status){

        if($status == 'Diterima'){
            $this->deliveryOrder->update([
                'delivery_date' => $this->delivery_date,
                'delivery_time' => $this->delivery_time
            ]);
        }

        $this->deliveryOrder->update([
            'status' => $status
        ]);
    }

    public function finishDO(){
        foreach($this->deliveryOrder->items as $item){
            $counter_item = CounterItem::where('item_id', $item->item_id)
                            ->where('counter_id', $this->deliveryOrder->counter_id)
                            ->first();

            if($counter_item){
                $counter_item->update([
                    'quantity' => $counter_item->quantity + $item->quantity_recieved
                ]);
            } else {
                CounterItem::create([
                    'counter_id' => $this->deliveryOrder->counter_id,
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity_recieved
                ]);
            }
        }

        $this->deliveryOrder->update([
            'status' => 'Selesai'
        ]);

    }

    public function changeQuantityRecieved($val, $id){
        Log::debug($val);
        Log::debug($id);
        $this->deliveryOrder->items()
        ->where('id', $id)
        ->update([
            'quantity_recieved' => $val
        ]);
    }

}
