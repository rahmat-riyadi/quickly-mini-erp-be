<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShiftTime;
use Illuminate\Http\Request;

class ShiftTimeController extends Controller
{
    public function index(){

        $data = ShiftTime::all();

        return $this->response(
            status: 200,
            success: true,
            message: 'get shift time',
            data: $data
        );
    }
}
