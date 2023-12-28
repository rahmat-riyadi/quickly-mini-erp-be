<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => Carbon::parse($this->date)->translatedFormat('l, d F Y'),
            'counter' => $this->counter->name,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out
        ];
    }
}
