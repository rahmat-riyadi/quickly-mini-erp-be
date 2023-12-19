<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Form;

class WorkScheduleForm extends Form
{

    public function __construct()
    {
        $this->startWeek = Carbon::now()->startOfWeek();
        $this->endWeek = Carbon::now()->endOfWeek();
    }

    public function getAllDatesOfWeek() {

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            if($this->employee->currentWeekSchedule()->pluck('date')->contains($date->toDateString())){
                continue;
            }
            $this->dates[] = $date->toDateString();
        }
    
    }

    public $workSchedules;

    public ?Employee $employee;

    public $dates;

    public $startWeek;
    public $endWeek;

    #[Rule('required', message: 'counter harus diisi')]
    public $counter_id;
    
    #[Rule('required', message: 'waktu masuk harus diisi')]
    public $time_in;

    #[Rule('required', message: 'waktu keluar harus diisi')]
    public $time_out;

    #[Rule('required', message: 'tanggal harus diisi')]
    public $date;

    public $employee_id;

    public function setModel(Employee $employee){
        $this->employee = $employee;
        $this->getAllDatesOfWeek();
        $this->employee_id = $employee->id;
    }

    public function store(){
        WorkSchedule::create($this->all());
        $this->dates = [];
        $this->time_in = null;
        $this->time_out = null;
        $this->date = null;
        $this->counter_id = null;
        $this->getAllDatesOfWeek();
    }

    public function update(){
        // $this->workSchedule->update($this->all());
    }

   public function updateProperty($id, $property, $val){
        WorkSchedule::find($id)->update([
            $property => $val
        ]);
   }

   public function deleteSchedule($id){
       WorkSchedule::find($id)->delete();
       $this->dates = [];
       $this->getAllDatesOfWeek();
   }

}
