<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state}; 
middleware(['auth']);
name('cashier');

?>
<x-layouts.app subheaderTitle="Kasir" >
    @volt
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-custom card-stretch" id="product_card" >
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
                    <div class="card-body">
                        <div class="row">
                            @for ($i = 1; $i < 12; $i++)
                            <div class="col-4 mb-6">
                                <div class="card bg-light">
                                    <div class="card-body p-0 d-flex flex-column ribbon ribbon-top">
                                        <div class="ribbon-target bg-danger" style="top: -2px; right: 20px;">Habis</div>
                                        <div class="p-3" >
                                            <img class="rounded" style="object-fit: cover; width: 100%; max-height: 150px; object-position: center;" src="{{ asset('assets/media/download.jpeg') }}" alt="">
                                        </div>
                                        <p class="ml-3 text-dark font-size-lg mb-0" >Product 1</p>
                                        <p class="ml-3 mb-3" ><b>Rp 100,000</b></p>
                                        <button style="box-sizing: border-box;" class="btn btn-sm mx-3 btn-primary mb-3" >
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-custom card-stretch" id="order_detail_card" >
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
                            {{-- <div style="height: 600px;" ></div> --}}
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
        </div>
    </div>

    @push('script')
        <script>

            var OrderDetailCard = function() {
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

                    height=height - 210;

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

            OrderDetailCard.init('order_detail_card')
            OrderDetailCard.init('product_card')

        </script>
    @endpush

    @endvolt
</x-layouts.app>