<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    #[Rule('required')]
    public $name;

    public function setModel(Supplier $supplier){
        $this->supplier = $supplier;
        $this->name = $supplier->name;
    }

    public function store(){
        Supplier::create($this->all());
    }

    public function update(){
        $this->supplier->update($this->all());
    }
}
