<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{ state, mount, updated};
use App\Models\ItemCategory;
use App\Models\Item;
middleware(['auth']);
name('cashier');

state([
    'categories' => [],
    'items' => [],
    'category' => null,
    'keyword' => null
]);

mount(function (){
    $this->categories = ItemCategory::all();
    $this->items = Item::all();
});

$filter_items = function (){
    $this->items = Item::when(!empty($this->category), function($q){
        $q->where('category_id', $this->category);
    })
    ->when(!empty($this->keyword), function($q){
        $q->where('name', 'LIKE', '%'.$this->keyword.'%');
    })->get();
};

updated([
    'category' => $filter_items,
    'keyword' => $filter_items,
]);

?>
<x-layouts.app subheaderTitle="Kasir" >
    @volt
    <div class="container" >
        {{-- <div class="row">
            <div class="col">
                <div class="card card-custom card-stretch" style="box-shadow: none;" id="product_card" >
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                Product
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-icon btn-secondary">
                                <i class="flaticon2-dashboard"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="card-scroll">
                            <div style="flex-wrap: wrap; gap: 20px;" class="d-flex">
                                @for ($i = 0; $i < 10; $i++)
                                <div style="min-width: 210px; @if($i == 9) max-width: inherit; @else flex: 1; @endif" class="card card-custom">
                                    <div class="card-body d-flex p-3">
                                        <img class="mr-3" style="width: 60px; height: 60px;" src="{{ asset('assets/media/download.jpeg') }}" alt="">
                                        <div>
                                            <p class="m-0 text-dark" >Item</p>
                                            <small>asdf</small>
                                        </div>
                                    </div>
                                    <div class="card-footer p-0 px-3 border-0 d-flex justify-content-between align-items-center mb-2">
                                        <span>Rp 20,000</span>
                                        <button class="btn btn-icon btn-sm btn-primary p-2" style="width: fit-content; height: fit-content;" >
                                            <i class="flaticon2-plus icon-xs" ></i>
                                        </button>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-custom card-stretch " id="order_detail_card" >
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                Detail Pesanan
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-icon btn-light-danger mr-2">
                                <i class="flaticon2-drop"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-scroll">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-success font-weight-bold" >
                            Submit
                        </button>
                        <button class="btn btn-outline-secondary font-weight-bold">
                            Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- sdf --}}

        <div class="card card-custom card-stretch bg-transparent" data-sticky-container="" style="box-shadow: none;" id="product_card"  >
            <div class="card-header border-0 bg-white sticky" data-margin-top="20" style="z-index: 100;" data-sticky="true" >
                <div class="card-title">
                    <select wire:model.live="category" class="custom-select form-control ">
                        <option value="" >Semua</option>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-icon ml-4"  >
                        <input wire:model.live="keyword" type="text" style="width: 250px" class="form-control" placeholder="Search..."/>
                        <span><i class="flaticon2-search-1 icon-md"></i></span>
                    </div>
                </div>
            </div>
            <div class="card-body row p-0 mt-3"  >
                <div class="col">
                    <div class="card-scroll">
                        <div style="flex-wrap: wrap; gap: 20px;" class="d-flex">
                            @foreach($items as $i => $item)
                            <div style="min-width: 210px; @if($i == 9) max-width: inherit; @else flex: 1; @endif" class="card card-custom">
                                <div class="card-body d-flex p-4">
                                    <img class="mr-3 rounded-sm" style="width: 60px; height: 60px;" src="{{ asset('assets/media/download.jpeg') }}" alt="">
                                    <div>
                                        <p class="m-0 text-dark" style="font-size: 12px; text-transform: capitalize;" >{{ Str::lower($item->name) }}</p>
                                        <small>asdf</small>
                                    </div>
                                </div>
                                <div class="card-footer p-0 px-3 border-0 d-flex justify-content-between align-items-center mb-2">
                                    <span>Rp 20,000</span>
                                    <button class="btn btn-icon btn-sm btn-primary p-2" style="width: fit-content; height: fit-content;" >
                                        <i class="flaticon2-plus icon-xs" ></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-4" data-sticky-container >
                    <div  class="card card-custom sticky" data-margin-top="100" data-sticky="true" id="invoice_card" >
                        <div class="card-body">
                            <div class="card-scroll">
                                <ul>
                                    {{-- @foreach($items as $i => $item)
                                    <li></li>
                                    @endforeach --}}
                                </ul>
                            </div>
                            asdfas
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- @push('script') --}}
        {{-- <script>

            document.addEventListener('livewire:navigated', () => { 

                var ProductCard = function() {
                    // Private properties
                    var _element;
    
                    // Private functions
                    var _init=function() {
                        var scroll=KTUtil.find(_element, '.card-scroll');
                        var cardBody=KTUtil.find(_element, '.card-body');

                        var cardHeader=KTUtil.find(_element, '.card-header');
    
                        var height=KTLayoutContent.getHeight();
    
                        height=height - parseInt(KTUtil.actualHeight(cardHeader));
    
                        height=height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
                        height=height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element, 'paddingBottom'));
    
                        height=height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody, 'paddingBottom'));
                        height=height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));
    
                        height=height - 3;
    
    
                        KTUtil.css(scroll, 'height', height + 'px');
                    }
    
                    // Public methods
                    return {
                    init: function(id) {
                        _element=KTUtil.getById(id);
    
                        
                        if ( !_element) {
                            return;
                        }
    
                        // Initialize
                        _init();
    
                        // Re-calculate on window resize
                        KTUtil.addResizeHandler(function() {
                            _init();
                            
                            }
                        );
                    },
    
                    update: function() {
                        _init();
                    }
                    };
                }();

                var OrderDetailCard = function() {
                    // Private properties
                    var _element;
    
                    // Private functions
                    var _init=function() {
                        var scroll=KTUtil.find(_element, '.card-scroll');
                        var cardBody=KTUtil.find(_element, '.card-body');

                        var cardHeader=KTUtil.find(_element, '.card-footer');
    
                        var height=KTLayoutContent.getHeight();
    
                        height=height - parseInt(KTUtil.actualHeight(cardHeader));
    
                        height=height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
                        height=height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element, 'paddingBottom'));
    
                        height=height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody, 'paddingBottom'));
                        height=height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));
    
                        height=height - 150;
    
    
                        KTUtil.css(scroll, 'height', height + 'px');
                    }
    
                    // Public methods
                    return {
                    init: function(id) {
                        _element=KTUtil.getById(id);
    
                        
                        if ( !_element) {
                            return;
                        }
    
                        // Initialize
                        _init();
    
                        // Re-calculate on window resize
                        KTUtil.addResizeHandler(function() {
                            _init();
                            
                            }
                        );
                    },
    
                    update: function() {
                        _init();
                    }
                    };
                }();
    
                ProductCard.init('product_card')
                OrderDetailCard.init('invoice_card')

                @this.on('init_layout', () => {
                    ProductCard.init('product_card')
                    OrderDetailCard.init('invoice_card')
                })            

            })



        </script> --}}
        {{-- @endpush --}}

    

    @endvolt
</x-layouts.app>