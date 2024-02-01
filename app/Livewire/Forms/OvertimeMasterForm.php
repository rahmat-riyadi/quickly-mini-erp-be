<?php

namespace App\Livewire\Forms;

use App\Models\OvertimeMaster;
use Livewire\Attributes\Rule;
use Livewire\Form;

class OvertimeMasterForm extends Form
{
    public ?OvertimeMaster $overtimeMaster;

    #[Rule('required', message: 'Nama harus diisi')]
    public $name;

    #[Rule('required', message: 'pengali harus diisi')]
    public $multiplier;

    public function setModel(OvertimeMaster $overtimeMaster){
        $this->overtimeMaster = $overtimeMaster;
        $this->fill($overtimeMaster);
    }

    public function store(){
        OvertimeMaster::create($this->all());
    }

    public function update(){
        $this->overtimeMaster->update($this->all());
    }

}
