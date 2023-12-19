<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items(){
        return $this->hasMany(DeliveryOrderItem::class, 'do_id');
    }

    public function counter(){
        return $this->belongsTo(Counter::class, 'counter_id');
    }

}
