<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function deliveryOrder(){
        return $this->belongsTo(DeliveryOrder::class, 'do_id');
    }

    public function item(){
        return $this->belongsTo(Item::class, 'item_id');
    }

}
