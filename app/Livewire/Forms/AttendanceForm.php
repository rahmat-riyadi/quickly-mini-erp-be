<?php

namespace App\Livewire\Forms;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AttendanceForm extends Form
{
    public ?Attendance $attendance;
    
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

    public function setModel(Attendance $attendance){
        $this->attendance = $attendance;
        $this->fill($attendance);
    }


}
