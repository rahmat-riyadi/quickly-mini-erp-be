<?php

namespace App\Livewire\Forms;

use App\Models\Position;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PositionForm extends Form
{
    public ?Position $position;


    #[Rule('required')]
    public $name;

    public function setModel(Position $position){
        $this->position = $position;
        $this->name = $position->name;
    }

    public function store(){
        Position::create($this->all());
    }

    public function update(){
        $this->position->update($this->all());
    }
}
