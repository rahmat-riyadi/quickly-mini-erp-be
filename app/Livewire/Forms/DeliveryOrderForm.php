<?php

namespace App\Livewire\Forms;

use App\Models\DeliveryOrder;
use Livewire\Attributes\Rule;
use Livewire\Form;

class DeliveryOrderForm extends Form
{
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
    public $items;

    public function setModel(DeliveryOrder $deliveryOrder){
        $this->deliveryOrder = $deliveryOrder;
    }

    public function store(){
        DeliveryOrder::create($this->all());
    }

    public function update(){
        $this->deliveryOrder->update($this->all());
    }
}
