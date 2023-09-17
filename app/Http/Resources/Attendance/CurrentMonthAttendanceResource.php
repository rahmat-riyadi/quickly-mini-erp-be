<?php

namespace App\Http\Resources\Attendance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentMonthAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $attendanceTime = Carbon::parse($this->attendance_time);
        $entryTime = Carbon::parse($this->shift->from);
        $isLate = $attendanceTime->greaterThan($entryTime);


        return [
            'date' => Carbon::parse($this->created_at)->translatedFormat('l, d F Y'),
            'shift' => $this->shift->name,
            'deduction' => $this->deduction,
            'description' => $this->description,
            'is_late' => $this->is_late,
            'location' => $this->location,
            'attendance_time' => $this->attendance_time,
            'lattency' => $isLate ? $entryTime->diff($attendanceTime)->format('%H:%I:%S') : 0,
        ];
    }
}
