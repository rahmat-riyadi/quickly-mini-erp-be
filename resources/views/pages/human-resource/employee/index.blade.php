<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, usesPagination, with, on}; 
use App\Models\Employee;
use App\Models\Position;
middleware(['auth']);
name('human-resource.employee.index');

usesPagination();

state(['status', 'position', 'keyword']);

state([
    'perpage' => 10,
    'positions' => Position::all()
]);

on(['refresh' => '$refresh']);

with(fn()=> [
    'employees'  => Employee::with(['position'])
    ->when(!empty($this->keyword), function($q){
        $q->where('name', "LIKE", "%{$this->keyword}%");
    })
    ->when(!empty($this->position), function($q){
        $q->where('position_id', $this->position);
    })
    ->when(!empty($this->status), function($q){
        Log::info($this->status);
        $q->where('status', '=', $this->status == 'aktif');
    })
    ->latest()
    ->select(
        'id',
        'name',
        'status',
        'position_id',
        'image'
    )
    ->paginate($this->perpage)
])

?>

<x-layouts.app subheaderTitle="Pagawai" >
    @volt
    <div class="container">

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <a href="/human-resource/employee/form" wire:navigate class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Tambah Data</a>
                    <!--end::Button-->
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
                <div class="row mb-5">
                    <div class="col">
                        <select wire:model.live="position" class="custom-select form-control">
                            <option value="" >-- Pilih --</option>
                            @foreach ($positions as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Gambar
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Nama
                            </th>
                            <th class=" text-center" scope="col" >
                                Jabatan
                            </th>
                            <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                Status
                            </th>
                            <th style="vertical-align: middle;" >Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($employees as $i => $item)
                        <tr>
                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                            <td style="vertical-align: middle;" >
                                <img style="object-position: center; object-fit: cover;" width="80" height="80" src="{{ asset('storage/'.$item->image) }}" alt="">
                            </td>
                            <td style="vertical-align: middle;" >{{ $item->name }}</td>
                            <td style="vertical-align: middle;" class="text-center" >
                                {{ $item->position->name }}
                            </td>
                            <td style="vertical-align: middle;" class="text-center" >
                                <span class="text-{{ $item->status == 1 ? 'success' : 'danger' }}" >
                                    {{ $item->status == 1 ? 'Aktif' : 'Non Aktif' }}
                                </span>
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
                                <a href="/human-resource/employee/salary/${e.id}" wire:navigate class="btn btn-sm btn-light btn-icon" title="Delete">
                                    <span class="svg-icon svg-icon-md svg-icon-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" x="2" y="2" width="10" height="12" rx="2"/>
                                                <path d="M4,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,8 C2,6.8954305 2.8954305,6 4,6 Z M18,16 C19.1045695,16 20,15.1045695 20,14 C20,12.8954305 19.1045695,12 18,12 C16.8954305,12 16,12.8954305 16,14 C16,15.1045695 16.8954305,16 18,16 Z" fill="#000000"/>
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

                    {{ $employees->links('components.pagination') }}
                    
                    <div class="d-flex align-items-center py-3">
                        <select wire:model.live="perpage" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 75px;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <span class="text-muted">Menampilkan {{ $employees->links()->paginator->count() }} dari {{  $employees->links()->paginator->total() }} data</span>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
    </div>

    <script>

        function refresh(){
            window.Livewire.dispatch('refresh')
        }

    </script>

    @endvolt
</x-layouts.app>
