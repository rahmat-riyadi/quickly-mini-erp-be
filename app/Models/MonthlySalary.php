<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySalary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function employee(){
        return $this->belongsTo(Employee::class)->select('id')->with('currentSalary');
    }

}
