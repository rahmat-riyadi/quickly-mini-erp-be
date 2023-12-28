<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index(Request $request){

        $data = $request->user()->currentWeekSchedule;

        return $this->response(
            status: 200,
            success: true,
            message: 'get current week schedule success',
            data: ScheduleResource::collection($data)
        );

    }
}
