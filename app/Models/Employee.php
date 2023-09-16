<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id'];

    public function position(){
        return $this->belongsTo(Position::class)->select('id', 'name');
    }

    public function salaries(){
        return $this->hasMany(Salary::class);
    }

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }


}
