<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, on, updated}; 
middleware(['auth']);
use App\Models\Employee;
use App\Models\Attendance;
name('human-resource.attendance.all');

state([
    'list_of_employees' => [],
    'selected_employee' => null,
    'start_date' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),
    'end_date' => \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
});


$get_employee = function (){
    $data = Attendance::latest()
    ->where('employee_id', $this->selected_employee)
    ->whereBetween('created_at', [$this->start_date, $this->end_date])
    ->select(
        'id',
        'employee_id',
        'deduction',
        'location',
        'image',
        'is_late',
        DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as date"),
        DB::raw("TIME_FORMAT(attendance_time, '%H:%i') as attendance_time"),
        DB::raw("TIME_FORMAT(attendance_time_out, '%H:%i') as attendance_time_out"),
    )
    ->get();
    Log::info(json_decode($data));
    $this->dispatch('loadData', $data);
};


$get_salaries = function (){
    $data = Attendance::latest()->get();
    $this->dispatch('loadData', $data);
};

on(['set-employee' => function ($val){
    $this->selected_employee = $val;
}]);

?>

<x-layouts.app subheaderTitle="Absensi" >
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    @volt
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col">
                                <div wire:ignore class="form-group m-0">
                                    <label style="display: block;" >Pegawai </label>
                                    <select wire:model="item" class="form-control" style="width: 100%;" id="select_2" >
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach ($list_of_employees as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group m-0">
                                    <label>Tanggal Mulai </label>
                                    <input wire:model="start_date" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group m-0">
                                    <label>Tanggal Mulai </label>
                                    <input  wire:model="end_date"type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-2 align-self-end">
                                <button wire:click="get_employee" type="button" class="btn btn-primary btn-block" >
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card card-custom mt-6">
            <div wire:ignore class="card-body">
                {{-- <div id="excel-container"></div> --}}
                <div id="myGrid" class="ag-theme-alpine" style="height: 450px"></div>
            </div>
        </div>
        {{-- <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary save" >
                Simpan
            </button>
        </div> --}}

    </div>

    {{-- <script>

        document.addEventListener('livewire:navigated', () => {

            function saveSchedule(data){
                $.ajax({
                    url: "{{ route('attendance.update') }}",
                    method: 'POST',
                    data: {
                        attendances: data
                    },
                    beforeSend: () => {
                        Swal.fire({
                            title: "<div class='spinner-border text-info' role='status'></div>",
                            text: "Menyimpan data...",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                    },
                    success: res => {
                        window.Livewire.dispatch('getSchedules')
                        Swal.fire({
                            icon: 'success',
                            title: "Berhasil!",
                            text: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: err => {
                        Swal.fire({
                            icon: 'error',
                            title: "Gagal",
                            text: err.responseJSON.message ?? 'Kesalahan internal',
                            showCloseButton: true,
                            showConfirmButton: false,
                        });
                    },
                })
            }

            function deleteData(id){
                $.ajax({
                    url: '/human-resource/attendance/delete/' + id,
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: res => console.log(res),
                    error: err => console.log(err),
                })
            }

            function getFormattedDate() {
                const today = new Date();
                
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Month dimulai dari 0, jadi perlu ditambah 1
                const year = today.getFullYear();
        
                return `${day}/${month}/${year}`;
            }

            $('#select_2').select2({
                placeholder: "Pilih Pegawai"
            });
            
            $('#select_2').on('change', (e) => {
                Livewire.dispatch('getEmployee', { id: e.target.value})
            })

            const container = document.querySelector('#excel-container');

            const hot = new Handsontable(container, {
                cells: function(row, col, prop) {
                    var cellProperties = {};
                    if(['formatted_late', 'act'].includes(prop)){
                        cellProperties.className = 'htMiddle htCenter';
                    }
                    if(['deduction'].includes(prop)){
                        cellProperties.className = 'htMiddle htRight';
                    }
                    return cellProperties;
                },
                hiddenColumns: {
                    columns: [0,1],
                },
                filters: true,
                dropdownMenu: true,
                className: 'htMiddle ',
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'is_late'
                    },
                    {
                        data: 'date',
                        type: 'date',
                        width: 70,
                        readOnly: true,
                    },
                    {
                        data: 'attendance_time',
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true,
                        width: 50,
                    },
                    {
                        data: 'attendance_time_out',
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true,
                        width: 50
                    },
                    {
                        data: 'location',
                        width: 150
                    },
                    {
                        data: 'formatted_late',
                        width: 50,
                        type: 'dropdown',
                        source: ['Ya', 'Tidak'],
                    },
                    {
                        data: 'deduction',
                        width: 60,
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,00'
                        }
                    },
                    {   
                        data:'id',
                        renderer: (instance, td, row, col, prop, value, cellProperties) => {
                            td.innerHTML = `<a wire.navigate.hover href="/human-resource/attendance/detail/${value}" class="btn text-primary font-weight-bolder" >Detail</a>`
                        }
                    }
                ],
                rowHeaders: true,
                colHeaders: true,
                colHeaders: ['id', 'is_late', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Lokasi', 'Terlambat', 'Potongan', 'Aksi'],
                contextMenu: true,
                height: 350,
                rowHeights: 35,
                manualRowMove: true,
                stretchH: 'all', 
                licenseKey: 'non-commercial-and-evaluation',  // for non-commercial use only
                afterChange: (changes) => {
                    changes?.forEach(([row, prop, oldVal, newVal]) => {
                        if(prop == 'formatted_late'){
                            if(newVal == 'Ya'){
                                hot.setDataAtCell(row, 1, 1)
                            } else {
                                hot.setDataAtCell(row, 1, 0)
                            }
                        }

                    })
                },
                beforeRemoveRow: (row, amount, rows) => {
                    rows.forEach(row => {
                        deleteData(hot.getDataAtCell(row, 0) ?? 0)
                    })
                }
            });

            window.Livewire.on('loadData', ([ data ]) => {
                hot.loadData(data)  
            })

            window.Livewire.on('setCounterId', ([row, id]) => {
                hot.setDataAtCell(row, 1, id)
            })

            document.querySelector('.save').addEventListener('click', () => {
                saveSchedule(hot.getData())
            })
            
        })


    </script> --}}
    @endvolt
    <script>

        function deleteData(id){

            const isDelete = confirm("apakah ingin mengaapus?")

            if(isDelete){
                $.ajax({
                    url: '/human-resource/attendance/delete/' + id,
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: res => console.log(res),
                    error: err => console.log(err),
                })
            }
            return
        }

        var instance

        const gridOptions = {
            // Row Data: The data to be displayed.
            rowData: [],
            columnDefs: [
                { 
                    field: "date", 
                    headerName: 'Tanggal', 
                    pinned: 'left', 
                    cellDataType: 'date',
                },
                { field: "attendance_time", headerName: 'Waktu Masuk', width: 140 },
                { field: "attendance_time_out", headerName: 'Waktu Keluar', width: 140 },
                { 
                    field: "is_late", 
                    headerName: 'Terlambat', 
                    width: 120, 
                    editable: true,
                },
                { field: "deduction", headerName: 'potongan', width: 120, editable: true },
                { field: "location", headerName: 'Lokasi', width: 300 },
                { 
                    field: "id", 
                    headerName: 'Aksi',
                    pinned: 'right',
                    width: 160,
                    cellRenderer: params => {
                        return `
                        <a href="/human-resource/attendance/detail/${params.value}" class="btn btn-sm btn-primary" >Detail</a>
                        <button onclick="deleteData(${params.value})" class="btn btn-sm btn-danger" >Hapus</button>
                        `
                    }
                },
            ],
            getRowId: (params) => params.data.id,
            readOnlyEdit: true,
            onCellEditRequest: event => {
                console.log(event);
                const oldData = event.data;
                const field = event.colDef.field;
                const newValue = event.newValue;
                const newData = { ...oldData };
                $.ajax({
                    url: "/human-resource/attendance/update/" + event.data.id,
                    method: 'POST',
                    data: {
                        field: event.colDef.field,
                        value: event.newValue
                    }, 
                    success: res => {
                        console.log(res)
                        newData[field] = event.newValue
                        const tx = {
                            update: [newData],
                        };
                        const rowNode = instance.getRowNode(event.data.id);
                        rowNode.setData({ ...newData })
                    },
                    error: res => {
                        const rowNode = instance.getRowNode(event.data.id);
                        rowNode.setData({ ...oldData })
                        console.log(res)
                        alert('Gagal Mengubah data')
                    }
                })
            }
        };

        // Your Javascript code to create the grid
        const myGridElement = document.querySelector('#myGrid');
        instance = agGrid.createGrid(myGridElement, gridOptions);

        window.addEventListener('livewire:navigated', () => {

            $('#select_2').select2({
                placeholder: "Pilih Pegawai"
            });
            
            $('#select_2').on('change', (e) => {
                Livewire.dispatch('set-employee', { val: e.target.value})
            })

            Livewire.on('loadData', ([ data ]) => {
                instance.setGridOption(
                    'rowData',
                    data.map(row => {
                        const dateParts = row.date.split('/')
                        console.log(new Date(
                                parseInt(dateParts[2]),
                                parseInt(dateParts[1]) - 1,
                                parseInt(dateParts[0])
                            ))
                        return {
                            ...row,
                            is_late: row.is_late == 1,
                            date: new Date(
                                parseInt(dateParts[2]),
                                parseInt(dateParts[1]) - 1,
                                parseInt(dateParts[0])
                            ),
                        }
                    })
                )
            })  
        })

    </script>
</x-layouts.app>
