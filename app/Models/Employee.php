<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function salary(){
        return $this->hasMany(Salary::class);
    }

    public function monthlySalary(){
        return $this->hasMany(MonthlySalary::class);
    }

}
