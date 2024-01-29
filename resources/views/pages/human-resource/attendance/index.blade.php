<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, usesPagination, with, on}; 
use App\Models\Employee;
middleware(['auth']);
name('human-resource.attendance.index');

usesPagination();

state([
    'perpage' => 10,
    'keyword' => ''
]);

with(fn()=> [
    'employees'  => Employee::with(['position'])
    ->leftJoin('attendances', function($q){
        $q->on('attendances.employee_id', '=','employees.id')
        ->whereDate('attendances.created_at', \Carbon\Carbon::now())
        ->latest();
    })
    ->when(!empty($this->keyword), function($q){
        $q->where('name', "LIKE", "%{$this->keyword}%");
    })
    ->select(
        'employees.id',
        'employees.name',
        'attendances.status',
        'attendances.is_late',
    )
    ->paginate($this->perpage)
])

?>

<x-layouts.app subheaderTitle="Absensi - Hari ini" >
    @volt
    <div class="container">

        {{ Log::info($employees) }}

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Absensi</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="input-icon mr-5">
                        <input wire:model.live="keyword" type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                    </div>
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
                {{-- <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div> --}}
                <table class="table table-hover table-bordered" >
                    <thead class="text-center text-uppercase" >
                        <tr>
                            <th style="vertical-align: middle;" width="50" class="" scope="col" >
                                #
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Nama
                            </th>
                            <th class=" text-center" scope="col" >
                                Status
                            </th>
                            <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                Terlambat
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
                                @if ($item->status == 'Sedang Bekerja')
                                    <span class="text-success" >{{ $item->status }}</span>
                                @else
                                {{ $item->status }}
                                @endif
                            </td>
                            <td style="vertical-align: middle;" class="text-center" >
                                {{ $item->is_late ? 'Ya' : 'Tidak' }}
                            </td>
                            <td style="vertical-align: middle;" >
                                <a href="/human-resource/attendance/today/{{ $item->id }}" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
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

    @push('script')
    
        <script>

            var datatable = $('#kt_datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            url: "{{ route('attendance.post') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            map: function(raw) {
                                // sample data mapping
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                return dataSet;
                            },
                        },
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                },

                rows: {
					autoHide: false
				},

                // layout definition
                layout: {
                    scroll: true,
                    footer: false,
                },

                // column sorting
                pagination: true,

                search: {
                    input: $('#kt_datatable_search_query'),
                    key: 'generalSearch'
                },

                // columns definition
                columns: [{
                    field: 'DT_RowIndex',
                    title: '#',
                    width: 30,
                    type: 'number',
                    textAlign: 'center',
                    sortable: false
                },{
                    field: 'position',
                    title: 'Nama',
                    width: 210,
                    template: function (e){
                        return `
                        <p class="m-0" > <span class="font-weight-bold" >${e.name}</span> <br> <span class="text-muted" >${e.position.name}</span></p>
                        `
                    }
                },{
                    field: 'status',
                    title: 'Status',
                    width: 120,
                    template: e => {

                        if(e.attendance_time_out){
                            return `<span>Selesai Bekerja</span>`
                        }

                        return `<span class="${e.status == 'Sedang Bekerja' ? 'text-success font-weight-bold' : ''}" >${e.status ?? ''}</span>`
                    }
                },{
                    field: 'description',
                    title: 'keterangan',
                },{
                    field: 'is_late',
                    title: 'Keterlambatan',
                    width: 120,
                    template: function (e){
                        // return `<span class="label label-light-${e.is_late ? 'danger' : 'success'} label-pill label-inline mr-2">${e.is_late ? 'Terlambat' : 'Tepat Waktu'}</span>`
                        console.log(e.is_late)
                        if(e.is_late == null){
                            return `<p class="m-0 font-weight-bold " ><span class="label label-dot mr-2"></span> Belum absen</p>`
                        }
                        return `<p class="m-0 font-weight-bold ${e.is_late ? 'text-danger' : 'text-info'}" ><span class="label label-dot label-${e.is_late ? 'danger' : 'info'} mr-2"></span> ${e.is_late ? 'Terlambat' : 'Tepat Waktu'}</p>`
                    }
                },{
                    field: 'Actions',
                    title: 'Aksi',
                    sortable: false,
                    width: 125,
                    overflow: 'visible',
                    autoHide: false,
                    textAlign: 'center',
                    template: function(e) {
                        return `\
                        <a href="/human-resource/attendance/today/${e.id}" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">\
                            <span class="svg-icon svg-icon-md svg-icon-success">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                        
                        `
                    }
                }],

            });

        </script>
        
    @endpush
    @endvolt
</x-layouts.app>
