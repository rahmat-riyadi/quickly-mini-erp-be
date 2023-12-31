<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, with, usesPagination, mount}; 
use App\Models\CounterItem;
use App\Models\Counter;
use App\Models\ItemCategory;
middleware(['auth']);
name('counter-menu.inventory.item.index');


usesPagination();

state([
    'perpage' => 5,
    'categories' => null,
    'category' => null,
    'keyword' => null
]);

mount(function (){
   $this->categories = ItemCategory::all();
});

with(fn () => [
    'items' => CounterItem::join('items', function ($q){
        $q->on('items.id', '=', 'counter_items.item_id')
        ->join('item_categories', 'item_categories.id', '=','items.category_id')
        ->when(!empty($this->category), function() use ($q){
            $q->where('category_id', $this->category);
        })
        ->when(!empty($this->keyword), function() use ($q){
            $q->where('name', 'LIKE', "%{$this->keyword}%");
        });
    })
    ->where('counter_items.counter_id', auth()->user()->counter->id)
    ->select('items.name', 'item_categories.name as category', 'counter_items.quantity', 'items.unit as unit')
    ->paginate($this->perpage)
]);

?>

<x-layouts.app subheaderTitle="Gudang" >
    @volt
    <div class="container">

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Barang</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    {{-- <div class="input-icon mr-5">
                        <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                    </div> --}}
                    <!--end::Dropdown-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                @if (session('success'))
                <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                    <div class="alert-text">{{ session('success') }}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                    <div class="alert-text">{{ session('error') }}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
                @endif
                <!--end: Datatable-->
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Kategori</label>
                            <div></div>
                            <select wire:model.live="category" class="custom-select form-control">
                                <option value="">Semua</option>
                                @foreach ($categories ?? [] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group " style="flex: 1;" >
                            <label>Cari Barang</label>
                            <input wire:model.live="keyword" type="text" class="form-control" >
                        </div>
                    </div>
                </div>
                <table class="table table-bordered" >
                    <thead class="text-center text-uppercase" >
                        <tr>
                            <th style="vertical-align: middle;" width="50" class="" scope="col" >
                                #
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Kelompok 
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Barang
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Stok
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($items as $i => $item)
                        <tr>
                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                            <td style="vertical-align: middle;" >{{ $item->category }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ $item->name }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ $item->quantity }} ({{ $item->unit }})</td>
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

    @endvolt
</x-layouts.app>
