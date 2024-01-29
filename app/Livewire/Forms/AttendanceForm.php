<?php

namespace App\Livewire\Forms;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AttendanceForm extends Form
{
    public ?Attendance $attendance;
    public ?Employee $employee;


    #[Rule('required')]
    public $status;

    #[Rule('required')]
    public $attendance_time;

    #[Rule('nullable')]
    public $attendance_time_out;

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

    #[Rule('required', message: 'Jenis lembur harus diisi')]
    public $overtime_type;

    #[Rule('required', message: 'Waktu mulai lembur harus diisi')]
    public $start_time;

    #[Rule('required', message: 'Waktu akhir lembur harus diisi')]
    public $end_time;

    public $amount;

    #[Rule('required', message: 'Counter harus diisi')]
    public $counter_id;

    public function setModel(Employee $employee){

        $this->employee = $employee;
        $this->attendance = Attendance::whereDate('created_at', Carbon::now())
                            ->where('employee_id', $employee->id)
                            ->first();

        $this->fill($this->attendance);

        if (!is_null($this->attendance->overtime)) {
            $this->fill([
                'overtime_type' => $this->attendance->overtime->overtime_type,
                'start_time' => $this->attendance->overtime->start_time,
                'end_time' => $this->attendance->overtime->end_time,
                'amount' => $this->attendance->overtime->amount,
            ]);
        }

        if (!is_null($this->attendance->split)) {
            $this->fill([
                'counter_id' => $this->attendance->split->counter_id,
            ]);
        }

        $workSchedule = WorkSchedule::where('employee_id', $employee->id)
                        ->where('date', Carbon::now()->format('Y-m-d'))
                        ->first();

        $timeIn = Carbon::parse($workSchedule->time_in);
        $attendanceTime = Carbon::parse($this->attendance->attendance_time);
        $diff = $attendanceTime->greaterThan($timeIn) ? $attendanceTime->diff($timeIn)->format('%H:%I:%S') : 0;

        $this->fill(['lattency' => $diff]);


    }

    public function update(){
        $this->attendance->update([
            'attendance_time' => $this->attendance_time,
            'attendance_time_out' => $this->attendance_time_out,
            'location' => $this->location,
            'deduction' => $this->deduction,
            'is_late' => $this->is_late,
        ]);
    }

    public function storeOvertime(){
        $this->attendance->overtime()->updateOrCreate([
            'attendance_id' => $this->attendance->id,
        ],[
            'overtime_type' => $this->overtime_type,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'amount' => $this->amount ?? 0,
        ]);
    }

    public function storeSplit(){
        $this->attendance->split()->updateOrCreate([
            'attendance_id' => $this->attendance->id,
        ],[
            'counter_id' => $this->counter_id
        ]);
    }


}
