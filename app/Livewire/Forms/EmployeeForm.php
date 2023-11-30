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
    public $newPassword;

    #[Rule('required')]
    public $status;

    public function setModel(Employee $employee){
        $this->employee = $employee;
        $this->fill($employee);
    }

    public function store(){

        $data = $this->all();

        if($this->image){
            $data['image'] = $this->image->store('employee-image');
        }

        Employee::create($data);
    }

    public function update(){

        $data = $this->all();

        if(isset($this->newPassword)){
            $data['password'] = bcrypt($this->newPassword);
        }

        $this->employee->update($this->all());
    }
}
