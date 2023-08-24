<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItemGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function warehouseItem(){
        return $this->hasMany(WarehouseItemGroup::class);
    }
}
