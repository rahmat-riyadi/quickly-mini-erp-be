<?php

namespace App\Livewire\Forms;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AttendanceForm extends Form
{
    public ?Attendance $attendance;
    public ?Employee $employee;

    #[Rule('required')]
    public $shift_time_id;

    #[Rule('required')]
    public $status;

    #[Rule('required')]
    public $attendance_time;

    #[Rule('required')]
    public $is_late;

    #[Rule('required')]
    public $description;

    #[Rule('required')]
    public $location;

    #[Rule('required')]
    public $deduction;
    
    #[Rule('required')]
    public $image;
    
    #[Rule('required')]
    public $lattency;

    public function setModel(Employee $employee){

        Log::debug($employee);

        $this->employee = $employee;
        $this->attendance = Attendance::whereDate('created_at', Carbon::now())
                            ->where('employee_id', $employee->id)
                            ->first();

        $this->fill($this->attendance);

        $timeIn = Carbon::parse($this->attendance->shift->from);
        $attendanceTime = Carbon::parse($this->attendance->attendance_time);
        $diff = $attendanceTime->greaterThan($timeIn) ? $attendanceTime->diff($timeIn)->format('%H:%I:%S') : 0;

        $this->fill(['lattency' => $diff]);


    }


}
