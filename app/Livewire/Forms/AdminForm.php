<?php

namespace App\Livewire\Forms;

use App\Models\Admin;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AdminForm extends Form
{
    public ?Admin $admin;


    public function setModel(Admin $admin){
        $this->admin = $admin;
    }

    public function store(){
        Admin::create($this->all());
    }

    public function update(){
        $this->admin->update($this->all());
    }
}
