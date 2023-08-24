<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function warehouseItemGroup(){
        return $this->belongsTo(WarehouseItemGroup::class);
    }

}
