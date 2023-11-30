<?php

namespace App\Livewire\Forms;

use App\Models\SaleItem;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SaleItemForm extends Form
{
    public ?SaleItem $saleItem;

    public function __construct()
    {   
        $this->status = true;
        $this->is_use_cup = false;
    }

    #[Rule('required', message: 'Nama harus diisi')]
    public $name;

    #[Rule('required', message: 'Harga harus diisi')]
    public $price;

    #[Rule('required', message: 'Harga 2 harus diisi')]
    public $price_2;

    #[Rule('nullable')]
    public $status;

    #[Rule('nullable')]
    public $is_use_cup;

    #[Rule('required', message: 'Kategori harus diisi')]
    public $sale_item_group_id;

    public function setModel(SaleItem $saleItem){
        $this->saleItem = $saleItem;
        $this->fill($saleItem);
    }

    public function store(){
        SaleItem::create($this->all());
    }

    public function update(){
        $this->saleItem->update($this->all());
    }
}
