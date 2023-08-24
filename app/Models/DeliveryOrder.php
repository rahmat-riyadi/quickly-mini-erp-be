<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    public $with = ['counter'];

    protected $guarded = ['id'];

    public function counter(){
        return $this->belongsTo(Counter::class)->select(['id','name']);
    }

}
