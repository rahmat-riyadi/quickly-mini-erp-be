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
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
});


$get_employee = function ($id){
    $this->selected_employee = $id;
    $data = Attendance::latest()
    ->select(
        'id',
        'employee_id',
        'deduction',
        'location',
        'image',
        'is_late',
        DB::raw("(CASE WHEN is_late = 1 THEN 'Ya' ElSE 'Tidak' END) as formatted_late"),
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

on(['getEmployee' => 'get_employee']);

?>

<x-layouts.app subheaderTitle="Absensi" >
    @volt
    <div class="container">

        <div class="row">
            <div class="col">
                <div class="card card-custom">
                    <div class="card-body p-4">
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
                </div>
            </div>
            {{-- <div class="col">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-0">
                                    <label style="display: block;" >Dari </label>
                                    <input wire:model.live="from" type="date" class="form-control" name="" id="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-0">
                                    <label style="display: block;" >Sampai </label>
                                    <input wire:model.live="until" type="date" class="form-control" >
                                </div>
                            </div>
                            <div class="col align-self-end">
                                <button type="button" wire:click="reset_filter" class="btn btn-light btn-block">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>


        <div class="card card-custom mt-6">
            <div wire:ignore class="card-body">
                <div id="excel-container"></div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary save" >
                    Simpan
                </button>
            </div>
        </div>

    </div>

    <script>

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
                    url: '/human-resource/work-schedule/delete/' + id,
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
                    if(['formatted_late'].includes(prop)){
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
                ],
                rowHeaders: true,
                colHeaders: true,
                colHeaders: ['id', 'is_late','Tanggal', 'Jam Masuk', 'Jam Keluar', 'Lokasi', 'Terlambat', 'Potongan'],
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


    </script>

    @endvolt
</x-layouts.app>
