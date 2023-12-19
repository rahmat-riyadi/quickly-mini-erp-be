<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Counter extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = ['id'];

    public function counterItem(){
        return $this->hasMany(CounterItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
