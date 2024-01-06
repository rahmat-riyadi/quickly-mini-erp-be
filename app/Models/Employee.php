<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function salary(){
        return $this->hasMany(Salary::class);
    }

    public function currentMonthAttendance(){
        return $this->hasMany(Attendance::class)->whereMonth('created_at', Carbon::now());
    }

    public function currentWeekSchedule(){
        return $this->hasMany(WorkSchedule::class)->whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    public function schedule(){
        return $this->hasMany(WorkSchedule::class)->latest('date');
    }

}
