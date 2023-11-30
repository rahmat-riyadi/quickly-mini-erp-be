<?php

namespace App\Livewire\Forms;

use App\Models\SaleItemGroup;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SaleItemGroupForm extends Form
{
    public ?SaleItemGroup $saleItemGroup;

    #[Rule('required', message: 'Kategori harus diisi')]
    public $name;

    public function setModel(SaleItemGroup $saleItemGroup){
        $this->saleItemGroup = $saleItemGroup;
        $this->fill($saleItemGroup);
    }

    public function store(){
        SaleItemGroup::create($this->all());
    }

    public function update(){
        $this->saleItemGroup->update($this->all());
    }
}
