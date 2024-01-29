<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getAttendanceTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }

    public function shift(){
        return $this->belongsTo(ShiftTime::class, 'shift_time_id');
    }

    public function overtime(){
        return $this->hasOne(Overtime::class);
    }

    public function split(){
        return $this->hasOne(Split::class);
    }

}
