<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, usesPagination, with, on, mount}; 
use App\Models\Employee;
use App\Models\Position;
use App\Models\Item;
middleware(['auth']);
name('operational.item.index');

usesPagination();

state(['status', 'position', 'keyword']);

state([
    'perpage' => 10,
    'positions' => Position::all()
]);

mount(function (){
   $data = Item::with('category')->get();
   $this->dispatch('load-data', $data);
});

// on(['refresh' => '$refresh']);

// with(fn()=> [
//     'employees'  => Employee::with(['position'])
//     ->when(!empty($this->keyword), function($q){
//         $q->where('name', "LIKE", "%{$this->keyword}%");
//     })
//     ->when(!empty($this->position), function($q){
//         $q->where('position_id', $this->position);
//     })
//     ->when(!empty($this->status), function($q){
//         Log::info($this->status);
//         $q->where('status', '=', $this->status == 'aktif');
//     })
//     ->latest()
//     ->select(
//         'id',
//         'name',
//         'status',
//         'position_id',
//         'image'
//     )
//     ->paginate($this->perpage)
// ])

?>

<x-layouts.app subheaderTitle="Barang" >
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    @volt
    <div class="container">

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Barang</h3>
                </div>
                {{-- <div class="card-toolbar">
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
                </div> --}}
            </div>
            <div class="card-body pt-0">
                <div wire:ignore >
                    <div id="myGrid" class="ag-theme-alpine" style="height: 540px"></div>
                </div>
            </div>
        </div>
    </div>


    @script
    <script>

        const myGridElement = document.querySelector('#myGrid');
        const gridOptions = {
            rowData: [],
            columnDefs: [
                { 
                    field: "name", 
                    headerName: 'Barang', 
                    pinned: 'left', 
                    width: 260,
                    filter: true,
                    floatingFilter: true
                },
                {
                    field: "category.name", 
                    headerName: 'Kelompok', 
                    filter: true,
                    floatingFilter: true,
                    flex: 1.5,
                    minWidth: 160
                },
                {
                    field: "unit", 
                    headerName: 'Satuan', 
                    flex: 1,
                    minWidth: 120
                },
                {
                    field: "type", 
                    headerName: 'Bagian', 
                    flex: 1,
                    minWidth: 120
                },
                {
                    field: "initial_stock", 
                    headerName: 'Stok Awal', 
                    width: 120
                },
                {
                    field: "minimum_stock", 
                    headerName: 'Stok Mininum', 
                    width: 130
                },
                {
                    field: "stock", 
                    headerName: 'Stok', 
                    pinned: 'right',
                    width: 80,
                    editable: true,
                    cellDataType: 'number'
                },
                // { 
                //     field: "id", 
                //     headerName: 'Aksi',
                //     pinned: 'right',
                //     width: 160,
                //     cellRenderer: params => {
                //         return `
                //         <a href="/human-resource/attendance/detail/${params.value}" class="btn btn-sm btn-primary" >Detail</a>
                //         <button onclick="deleteData(${params.value})" class="btn btn-sm btn-danger" >Hapus</button>
                //         `
                //     }
                // },
            ],
            getRowId: (params) => params.data.id,
        }
        instance = agGrid.createGrid(myGridElement, gridOptions);

        Livewire.on('load-data', ([ data ]) => {
            instance.setGridOption('rowData', data)
        })

    </script>
    @endscript

    @endvolt
</x-layouts.app>
