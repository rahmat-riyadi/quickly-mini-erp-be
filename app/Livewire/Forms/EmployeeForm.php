<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class EmployeeForm extends Form
{


    public function __construct()
    {
        $this->status = 1;
    }

    public ?Employee $employee;

    #[Rule('required', message: 'nama harus diisi')]
    public $name;
    
    #[Rule('required', message: 'jabatan harus diisi')]
    public $position_id;

    #[Rule('required', message: 'nik harus diisi')]
    public $nik;

    #[Rule('required', message: 'kk harus diisi')]
    public $kk;

    #[Rule('required', message: 'alamat harus diisi')]
    public $address;

    #[Rule('required', message: 'tanggal lahir harus diisi')]
    public $date_of_birth;

    #[Rule('required', message: 'tempat lahir harus diisi')]
    public $place_of_birth;

    #[Rule('nullable')]
    public $city;

    #[Rule('nullable')]
    public $province;

    #[Rule('nullable')]
    public $religion;

    #[Rule('required', message: 'No HP lahir harus diisi')]
    public $phone;

    #[Rule('nullable')]
    public $email;
    
    #[Rule('required', 'tanggal masuk harus diisi')]
    public $entry_date;

    #[Rule('nullable')]
    public $exit_date;
    
    #[Rule('nullable')]
    public $image;
    
    #[Rule('nullable')]
    public $username;

    #[Rule('nullable')]
    public $password;

    #[Rule('nullable')]
    public $newPassword;

    #[Rule('nullable')]
    public $status;

    public function setModel(Employee $employee){
        $this->employee = $employee;
        $this->fill($employee);
    }

    public function store(){

        $data = $this->all();

        $data['password'] = bcrypt($this->password);

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

        $this->employee->update($data);
    }
}
