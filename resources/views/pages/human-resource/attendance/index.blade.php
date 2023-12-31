<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state}; 
middleware(['auth']);
name('human-resource.attendance.index')

?>

<x-layouts.app subheaderTitle="Kehadiran" >
    @volt
    <div class="container">

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Kehadiran</h3>
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
                <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
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
