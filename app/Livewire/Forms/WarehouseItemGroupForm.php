<?php

namespace App\Livewire\Forms;

use App\Models\WarehouseItemGroup;
use Livewire\Attributes\Rule;
use Livewire\Form;

class WarehouseItemGroupForm extends Form
{
    public ?WarehouseItemGroup $warehouseItemGroup;

    #[Rule('required', message: 'Kategori item harus diisi')]
    public $name;

    public function setModel(WarehouseItemGroup $warehouseItemGroup){
        $this->warehouseItemGroup = $warehouseItemGroup;
        $this->fill($warehouseItemGroup);
    }

    public function store(){
        WarehouseItemGroup::create($this->all());
    }

    public function update(){
        $this->warehouseItemGroup->update($this->all());
    }
}
