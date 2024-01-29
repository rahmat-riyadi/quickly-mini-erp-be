<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{ state, mount, updated, usesPagination, with};
use App\Models\ItemCategory;
use App\Models\Item;
middleware(['auth']);
name('cashier');
usesPagination();

state([
    'categories' => [],
    'perpage' => 5,
    'category' => '',
    'keyword' => '',
    'selected_item' => -1,
    'order_list' => []
]);

mount(function (){
    $this->categories = ItemCategory::all();
});

with(fn()=> [
    'items' => Item::when(!empty($this->category), function($q){
        $q->where('category_id', $this->category);
    })
    ->when(!empty($this->keyword), function($q){
        $q->where('name', 'LIKE', '%'.$this->keyword.'%');
    })
    ->paginate($this->perpage)
]);

$set_selected_item = function ($i){
    $this->selected_item = $i == $this->selected_item ? -1 : $i;
};

$handle_add_item = function ($val){

    Log::debug($val);

    if(count($this->order_list) == 0){
        $this->order_list[] = [
            'id' => $val['id'],
            'name' => $val['name'],
            'quantity' => 1,
            'price' => $val['sale_price']
        ];
        return;
    }

    [
        [
            'id' => 1,
            'name' => 'hehe'
        ],
        [
            'id' => 2,
            'name' => 'hehe'
        ],
    ];


};

?>


@push('heads')
    <style>

        .act-btn-wrapper {
            position: absolute;
            right: -10px;
            opacity: 0;
            transition: .3s;
        }

        .act-btn {
            width: 28px !important;
            height: 28px !important;
        }

        .item-price {
            transition: .3s;
        }

        .item-wrapper:hover .act-btn-wrapper,
        .item-wrapper.selected .act-btn-wrapper {
            right: 10px;
            opacity: 1;
        }

        .item-wrapper:hover .item-price,
        .item-wrapper.selected .item-price {
            margin-right: 70px;
        }

    </style>
@endpush

<x-layouts.app subheaderTitle="Kasir" >
    @volt
    <div class="container" >
        <div class="row">
            <div class="col-7">
                @if ($selected_item == -1)
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col">
                                <select wire:model.live="status" class="custom-select form-control">
                                    <option value="" >-- Pilih --</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                </select>
                            </div>
                            <div class="col">
                                <div class="input-icon ">
                                    <input wire:model.live="keyword" type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" >
                            <thead class="text-center text-uppercase" >
                                <tr>
                                    <th style="vertical-align: middle;" width="50" class="" scope="col" >
                                        #
                                    </th>
                                    <th style="vertical-align: middle;" width="100" class="" scope="col" >
                                        Gambar
                                    </th>
                                    <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                        Nama
                                    </th>
                                    <th class=" text-center" scope="col" >
                                        Gambar
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Status
                                    </th>
                                    <th style="vertical-align: middle;" >Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >
                                @foreach ($items as $i => $item)
                                <tr>
                                    <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                                    <td style="vertical-align: middle;" >
                                        <img style="object-position: center; object-fit: cover;" width="50" height="50" src="{{ asset('storage/'.$item->image) }}" alt="">
                                    </td>
                                    <td style="vertical-align: middle;" >{{ $item->name }}</td>
                                    <td style="vertical-align: middle;" class="text-center" >
                                        {{ number_format($item->sale_price) }}
                                    </td>
                                    <td style="vertical-align: middle;" class="text-center" >
                                        asf
                                    </td>
                                    <td style="vertical-align: middle;" >
                                        <button wire:click="handle_add_item({{ $item }})"  class="btn btn-sm btn-primary btn-icon mr-2" style="width: 30px; height: 30px;" title="Edit details">
                                            <i class="fas fa-cart-plus icon-nm" ></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
        
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
        
                            {{ $items->links('components.pagination') }}
                            
                            <div class="d-flex align-items-center py-3">
                                <select wire:model.live="perpage" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 75px;">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                <span class="text-muted">Menampilkan {{ $items->links()->paginator->count() }} dari {{  $items->links()->paginator->total() }} data</span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <p>sdfds</p>
                @endif
            </div>
            <div class="col">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0" >
                                Item Belanja
                            </h6>
                            <div class="btn btn-sm btn-icon btn-danger">
                                <i class="fas fa-trash-alt" ></i>
                            </div>
                        </div>
                        <div class="mt-4 mb-8" >
                            @foreach ($order_list as $i => $order)
                                <div class="bg-light item-wrapper mb-4 px-4 py-4 rounded position-relative {{ $selected_item == $i ? 'selected' : '' }}" >
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 font-weight-bold" >{{ $order['name'] }} ({{ $order['quantity'] }} x {{ $order['price'] }})</p>
                                        <p class="mb-0 ml-auto font-weight-bold item-price" > {{ number_format($order['quantity'] * $order['price']) }}</p>
                                        <div class="act-btn-wrapper" >
                                            <div class="btn act-btn btn-sm btn-icon btn-danger">
                                                <i class="fas fa-trash-alt " ></i>
                                            </div>
                                            <button wire:click="set_selected_item({{ $i }})" class="btn act-btn btn-sm btn-icon btn-primary ml-1">
                                                <i class="fas fa-clipboard" ></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div style="border-bottom-width: 2px !important;" class="border-bottom my-3"></div>
                                    @for ($n = 0; $n < 5; $n++)
                                        <div class="d-flex justify-content-between mb-2" >
                                            <span class="text-muted" >Taro Topping</span>
                                            <span class="text-muted" >35,000</span>
                                        </div>
                                    @endfor
                                </div>
                            @endforeach
                        </div>
                        <div class="border-bottom mb-5"></div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary mr-4">
                                Cetak
                            </button>
                            <button class="btn btn-primary mr-auto">
                                Submit
                            </button>
                            <h5 class="mb-0" >Rp 120,000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endvolt
</x-layouts.app>