<?php

namespace App\Livewire\Forms;

use App\Models\ShiftTime;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ShiftTimeForm extends Form
{
    public ?ShiftTime $shiftTime;

    #[Rule('required')]
    public $name;
    
    #[Rule('required')]
    public $from;

    #[Rule('required')]
    public $until;

    public function setModel(ShiftTime $shiftTime){
        $this->shiftTime = $shiftTime;
        $this->name = $shiftTime->name;
        $this->from = $shiftTime->from;
        $this->until = $shiftTime->until;
    }

    public function store(){
        ShiftTime::create($this->all());
    }

    public function update(){
        $this->shiftTime->update($this->all());
    }
}
