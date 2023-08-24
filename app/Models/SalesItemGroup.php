<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItemGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function salesItem(){
        return $this->hasMany(SalesItem::class);
    }

}
