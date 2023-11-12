<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\Salary;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SalaryForm extends Form
{
    public ?Salary $salary;

    public ?Employee $employee;

    #[Rule('required')]
    public $base_salary;

    #[Rule('required')]
    public $time_off;

    #[Rule('required')]
    public $attendance_intensive;

    public function setModel(Salary $salary){
        $this->salary = $salary;
    }

    public function store(){
        $this->employee->salary()->create($this->all());
    }

    public function update(){
        $this->salary->update($this->all());
    }

    public function setEmployee(Employee $employee){
        $this->employee = $employee;
    }
}
