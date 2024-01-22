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
    'keyword' => ''
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

        .item-wrapper:hover .act-btn-wrapper {
            right: 10px;
            opacity: 1;
        }

        .item-wrapper:hover .item-price {
            margin-right: 70px;
        }

    </style>
@endpush

<x-layouts.app subheaderTitle="Kasir" >
    @volt
    <div class="container" >
        <div class="row">
            <div class="col-7">
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
                                        <a href="/human-resource/employee/{{ $item->id }}" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
                                            <span class="svg-icon svg-icon-md svg-icon-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                        <a href="javascript:;" data-href="/human-resource/employee/delete/{{ $item->id }}" onclick="deleteData(this, function(){ refresh() })"  class="btn btn-sm btn-light btn-icon mr-2" title="Delete">
                                            <span class="svg-icon svg-icon-md svg-icon-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
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
                            @for ($i = 1; $i < 5; $i++)
                                <div class="bg-light item-wrapper mb-4 px-4 py-4 rounded position-relative" >
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 font-weight-bold" >Susu Milku (2 x 35,000)</p>
                                        <p class="mb-0 ml-auto font-weight-bold item-price" > 95,000</p>
                                        <div class="act-btn-wrapper" >
                                            <div class="btn act-btn btn-sm btn-icon btn-danger">
                                                <i class="fas fa-trash-alt " ></i>
                                            </div>
                                            <div class="btn act-btn btn-sm btn-icon btn-info ml-1">
                                                <i class="fas fa-plus" ></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-bottom-width: 2px !important;" class="border-bottom mt-3"></div>
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="d-flex" >
                                            
                                        </div>
                                    @endfor
                                </div>
                            @endfor
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