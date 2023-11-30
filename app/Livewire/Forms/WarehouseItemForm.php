<?php

namespace App\Livewire\Forms;

use App\Models\WarehouseItem;
use Livewire\Attributes\Rule;
use Livewire\Form;

class WarehouseItemForm extends Form
{
    public ?WarehouseItem $warehouseItem;

    #[Rule('required', message: 'Nama item harus diisi')]
    public $name;

    #[Rule('required', message: 'Harga beli harus diisi')]
    public $buy_price;

    #[Rule('required', message: 'Harga jual harus diisi')]
    public $sale_price;

    #[Rule('required', message: 'Kategori harus diisi')]
    public $warehouse_item_group_id;

    #[Rule('required', message: 'stok harus diisi')]
    public $stock;

    #[Rule('required', message: 'satuan harus diisi')]
    public $unit;


    public function setModel(WarehouseItem $warehouseItem){
        $this->warehouseItem = $warehouseItem;
        $this->fill($warehouseItem);
    }

    public function store(){
        WarehouseItem::create($this->all());
    }

    public function update(){
        $this->warehouseItem->update($this->all());
    }
}
