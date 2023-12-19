<?php

namespace App\Livewire\Forms;

use App\Models\ItemCategory;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ItemCategoryForm extends Form
{
    public ?ItemCategory $itemCategory;

    #[Rule('required', message: 'Field kategori harus diisi')]
    public $name;

    public function setModel(ItemCategory $itemCategory){
        $this->itemCategory = $itemCategory;
        $this->fill($itemCategory);
    }

    public function store(){
        ItemCategory::create($this->all());
    }

    public function update(){
        $this->itemCategory->update($this->all());
    }
}
