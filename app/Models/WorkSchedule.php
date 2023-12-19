<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function counter(){
        return $this->belongsTo(Counter::class);
    }

}
