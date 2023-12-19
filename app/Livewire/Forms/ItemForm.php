<?php

namespace App\Livewire\Forms;

use App\Models\Item;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ItemForm extends Form
{

    public function __construct()
    {
        $this->status = 1;
    }

    public ?Item $item;

    #[Rule('required', message: 'Nama item harus diisi')]
    public $name;

    #[Rule('required', message: 'Kategori item harus diisi')]
    public $category_id;

    #[Rule('required', message: 'Satuan item harus diisi')]
    public $unit;

    #[Rule('required', message: 'Konversi 1 harus diisi')]
    public $convertion_1;

    #[Rule('required', message: 'Konversi 2 harus diisi')]
    public $convertion_2;

    #[Rule('required', message: 'Harga beli harus diisi')]
    public $buy_price;

    #[Rule('required', message: 'Harga jual harus diisi')]
    public $sale_price;

    public $initial_stock;

    public $minimum_stock;

    public $average_stock;

    #[Rule('required', message: 'Jenis item harus diisi')]
    public $type;

    public $status;

    public function setModel(Item $item){
        $this->item = $item;
        $this->fill($item);
    }

    public function store(){
        Item::create($this->all());
    }

    public function update(){
        $this->item->update($this->all());
    }
}
