<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use Livewire\Attributes\Rule;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee;

    #[Rule('required')]
    public $name;
    
    #[Rule('required')]
    public $position_id;

    #[Rule('required')]
    public $nik;

    #[Rule('required')]
    public $kk;

    #[Rule('required')]
    public $address;

    #[Rule('required')]
    public $date_of_birth;

    #[Rule('required')]
    public $place_of_birth;

    #[Rule('nullable')]
    public $city;

    #[Rule('nullable')]
    public $province;

    #[Rule('nullable')]
    public $religion;

    #[Rule('required')]
    public $phone;

    #[Rule('nullable')]
    public $email;
    
    #[Rule('required')]
    public $entry_date;

    #[Rule('nullable')]
    public $exit_date;
    
    #[Rule('nullable')]
    public $image;
    
    #[Rule('nullable')]
    public $username;

    #[Rule('nullable')]
    public $password;

    #[Rule('required')]
    public $status;

    public function setModel(Employee $employee){
        $this->employee = $employee;
        $this->fill($employee);
        // $this->name = $employee->name;
        // $this->nik = $employee->nik;
        // $this->kk = $employee->kk;
        // $this->address = $employee->address;
        // $this->date_of_birth = $employee->date_of_birth;
        // $this->place_of_birth = $employee->place_of_birth;
        // $this->city = $employee->city;
        // $this->province = $employee->province;
        // $this->religion = $employee->religion;
        // $this->phone = $employee->phone;
        // $this->email = $employee->email;
        // $this->entry_date = $employee->entry_date;
        // $this->exit_date = $employee->exit_date;
        // $this->image = $employee->image;
        // $this->username = $employee->username;
        // $this->status = $employee->status;
    }

    public function store(){

        $data = $this->all();

        if($this->image){
            $data['image'] = $this->image->store('employee-image');
        }

        Employee::create($data);
    }

    public function update(){
        $this->employee->update($this->all());
    }
}
