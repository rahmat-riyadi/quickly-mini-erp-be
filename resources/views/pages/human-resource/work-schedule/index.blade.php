<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, with, usesPagination}; 
use App\Models\Employee;
middleware(['auth']);
name('human-resource.work-schedule.index');

usesPagination();

state([
    'perpage' => 10,
]);

with(fn() => [
    'employees' => Employee::with('currentWeekSchedule')
                ->where('status', true)
                ->paginate($this->perpage)
]);

?>

<x-layouts.app subheaderTitle="Jam Kerja" >
    @volt
    <div class="container">

        <div class="card card-custom">

            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Jam Kerja</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="input-icon mr-5">
                        <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                    </div>
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <a href="/" wire:navigate class="btn btn-primary font-weight-bolder">
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
                <table class="table table-hover table-bordered" >
                    <thead class="text-center text-uppercase" >
                        <tr>
                            <th style="vertical-align: middle;" width="50" scope="col" >
                                #
                            </th>
                            <th style="vertical-align: middle;" width="200" scope="col" >
                                Nama
                            </th>
                            <th class=" text-center" scope="col" >
                                Jumlah Hari Kerja
                            </th>
                            <th style="vertical-align: middle;" >Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($employees as $i => $item)
                        <tr>
                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                            <td style="vertical-align: middle;" >{{ $item->name }}</td>
                            <td style="vertical-align: middle;" class="text-center" >
                                @if (is_null($item->current_week_schedule))
                                <span class="label label-lg label-inline">Belum Ada jam kerja</span>
                                @else
                                {{ count($item->current_week_schedule) }}
                                @endif
                            </td>
                            <td>
                                <a href="/human-resource/work-schedule/{{ $item->id }}" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
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

    
    @endvolt
</x-layouts.app>
