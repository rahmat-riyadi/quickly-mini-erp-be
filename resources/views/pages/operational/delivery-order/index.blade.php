<?php
 
use function Laravel\Folio\{name,middleware,};
use function Livewire\Volt\{state, with, usesPagination}; 
use App\Models\DeliveryOrder;
use App\Models\Counter;
middleware(['auth']);
name('operational.delivery-order.index');


usesPagination();

state([
    'perpage' => 5,
    'counters' => Counter::all(),
    'counter' => null,
    'status' => null,
    'date' => null
]);

with(fn () => [
    'deliveryOrders' => DeliveryOrder::with('counter')
                        ->when(!empty($this->counter), function ($q) {
                            $q->where('counter_id', $this->counter);
                        })
                        ->when(!empty($this->status), function ($q) {
                            $q->where('status', $this->status);
                        })
                        ->when(!empty($this->date), function ($q) {
                            $q->where('order_date', $this->date);
                        })
                        ->latest()
                        ->paginate($this->perpage)
]);

?>

<x-layouts.app subheaderTitle="Delivery Order" >
    @volt
    <div class="container">

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar DO</h3>
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
                            <label>Counter</label>
                            <div></div>
                            <select wire:model.live="counter" class="custom-select form-control">
                                <option value="">Semua</option>
                                @foreach ($counters as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Status</label>
                            <div></div>
                            <select wire:model.live="status" class="custom-select form-control">
                                <option value="">Semua</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group " style="flex: 1;" >
                            <label>Tanggal</label>
                            <input wire:model.live="date" type="date" class="form-control" >
                        </div>
                        <button type="button" wire:click="$set('date', null)" class="btn btn-light btn-icon ml-5" title="Edit details">
                            <span class="svg-icon svg-icon-md svg-icon-success">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z" fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <table class="table table-hover table-bordered" >
                    <thead class="text-center text-uppercase" >
                        <tr>
                            <th style="vertical-align: middle;" width="50" rowspan="2" class="" scope="col" >
                                #
                            </th>
                            <th style="vertical-align: middle;" width="200" rowspan="2" class="" scope="col" >
                                Counter
                            </th>
                            <th colspan="2" class=" text-center" scope="col" >
                                Order
                            </th>
                            <th colspan="2" class=" text-center" scope="col" >
                                Delivery
                            </th>
                            <th style="vertical-align: middle;" rowspan="2" class=" text-center" scope="col" >
                                Status
                            </th>
                            <th style="vertical-align: middle;" rowspan="2" >Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center" >Tanggal</th>
                            <th class="text-center" >Jam</th>
                            <th class="text-center" >Tanggal</th>
                            <th class="text-center" >Jam</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($deliveryOrders as $i => $item)
                        <tr>
                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                            <td style="vertical-align: middle;" >{{ $item->counter->name }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ \Carbon\Carbon::parse($item->order_date)->translatedFormat('l, d-m-Y') }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ $item->order_time }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ is_null($item->delivery_date) ? '-' : \Carbon\Carbon::parse($item->delivery_date)->translatedFormat('l, d m Y') }}</td>
                            <td style="vertical-align: middle;" class="text-center" >{{ $item->delivery_time ?? '-' }}</td>
                            <td style="vertical-align: middle;" class="text-center" >
                                @switch($item->status)
                                    @case('Menunggu')
                                        <span class="label label-light-warning label-pill label-inline">Menunggu</span>
                                        @break
                                    @case('Diterima')
                                        <span class="label label-light-primary label-pill label-inline">Diterima</span>
                                        @break
                                    @case('Selesai')
                                        <span class="label label-light-success label-pill label-inline">Selesai</span>
                                        @break
                                    @case('Ditolak')
                                        <span class="label label-light-danger label-pill label-inline">Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="/operational/delivery-order/{{ $item->id }}" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    {{ $deliveryOrders->links('components.pagination') }}
                    
                    <div class="d-flex align-items-center py-3">
                        <select wire:model.live="perpage" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 75px;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <span class="text-muted">Menampilkan {{ $deliveryOrders->links()->paginator->count() }} dari {{  $deliveryOrders->links()->paginator->total() }} data</span>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    @endvolt
</x-layouts.app>
