<?php

namespace App\Livewire\Forms;

use App\Models\Counter;
use Livewire\Attributes\Rule;
use Livewire\Form;

class CounterForm extends Form
{
    public ?Counter $counter;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $code;

    #[Rule('required')]
    public $phone;

    public function setModel(Counter $counter){
        $this->counter = $counter;
        $this->name = $counter->name;
        $this->code = $counter->code;
        $this->phone = $counter->phone;
    }

    public function store(){
        Counter::create($this->all());
    }

    public function update(){
        $this->counter->update($this->all());
    }
}
