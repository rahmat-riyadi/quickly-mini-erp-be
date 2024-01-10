<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, on, updated}; 
middleware(['auth']);
use App\Models\Counter;
use App\Models\Employee;
use App\Models\WorkSchedule;
name('human-resource.work-schedule.index');

state([
    'list_of_employees' => [],
    'from' => '',
    'until' => '',
    'selected_employee' => null,
    'counters' => [],
    'schedules' => []
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
    $this->counters = Counter::pluck('name');

});


$get_employee = function ($id){
    $this->selected_employee = $id;
    $data = WorkSchedule::with('counter')
    ->where('employee_id', $id)
    ->when(!empty($this->from) || !empty($this->until), function ($q){

        if(empty($this->from)){
            $q->where('date','<=', $this->until);
            return;
        } 

        if(empty($this->until)){
            $q->where('date','>=', $this->from);
            return;
        } 

        $q->whereBetween('date',[
            $this->from,
            $this->until,
        ]);
    })
    ->select(
        'id',
        DB::raw("DATE_FORMAT(date, '%d/%m/%Y') as date"),
        'counter_id',
        'employee_id',
        DB::raw("TIME_FORMAT(time_in, '%H:%i') as time_in"),
        DB::raw("TIME_FORMAT(time_out, '%H:%i') as time_out"),
    )
    ->get();
    Log::info($this->schedules);
    $this->schedules = $data;
    $this->dispatch('loadData', $data);
};

$reset_filter = function (){
    $this->from = '';
    $this->until = '';
    $this->get_schedules();
};


$change_counter = function ($row, $name) {
    Log::info($row);
    $counter = Counter::where('name', $name)->first();
    $this->dispatch('setCounterId', $row, $counter->id);
};

$get_schedules = function (){
    $data = WorkSchedule::with('counter')
    ->where('employee_id', $this->selected_employee)
    ->when(!empty($this->from) || !empty($this->until), function ($q){

        Log::info($this->from);
        Log::info($this->until);

        if(empty($this->from)){
            $q->where('date','<=', $this->until);
            return;
        } 

        if(empty($this->until)){
            $q->where('date','>=', $this->from);
            return;
        } 

        $q->whereBetween('date',[
            $this->from,
            $this->until,
        ]);
    })
    ->select(
        'id',
        DB::raw("DATE_FORMAT(date, '%d/%m/%Y') as date"),
        'counter_id',
        'employee_id',
        DB::raw("TIME_FORMAT(time_in, '%H:%i') as time_in"),
        DB::raw("TIME_FORMAT(time_out, '%H:%i') as time_out"),
    )
    ->get();
    $this->schedules = $data;
    $this->dispatch('loadData', $data);
};

on(['change_counter' => 'change_counter']);
on(['getSchedules' => 'get_schedules']);
on(['getEmployee' => 'get_employee']);
updated([
    'from' => $get_schedules,
    'until' => $get_schedules,
]);

?>

<x-layouts.app subheaderTitle="Jam Kerja" >
    @volt
    <div class="container">

        <div class="row">
            <div class="col-4">
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
            <div class="col">
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
            </div>
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
                    url: "{{ route('workschedule.update') }}",
                    method: 'POST',
                    data: {
                        schedules: data
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
                data: {{ Js::from($schedules) }},
                cells: function(row, col, prop) {
                    var cellProperties = {};
                    if(['id', 'counter_id', 'employee_id'].includes(prop)){
                        cellProperties.className = 'htMiddle htCenter';
                    }
                    return cellProperties;
                },
                hiddenColumns: {
                    columns: [0,1,2]
                },
                className: 'htMiddle ',
                columns: [
                    {
                        width: 20,
                        data: 'id',
                        readOnly: true
                    },
                    {
                        width: 30,
                        data: 'counter_id',
                        readOnly: true
                    },
                    {
                        width: 30,
                        data: 'employee_id',
                        readOnly: true
                    },
                    {
                        data: 'date',
                        width: 50,
                        type: 'date',
                        dateFormat: 'DD/MM/YYYY',
                        correctFormat: true,
                        defaultDate: getFormattedDate(),
                        datePickerConfig: {
                            // First day of the week (0: Sunday, 1: Monday, etc)
                            firstDay: 0,
                            showWeekNumber: true,
                            disableDayFn(date) {
                            // Disable Sunday and Saturday
                                return date.getDay() === 0 || date.getDay() === 6;
                            }
                        },
                    },
                    {
                        data: 'counter.name',
                        width: 50,
                        type: 'dropdown',
                        source: {{ Js::from($counters) }},
                        strict: true,
                    },
                    {
                        data: 'time_in',
                        width: 50,
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true
                    },
                    {
                        data: 'time_out',
                        width: 50,
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true
                    },
                ],
                rowHeaders: true,
                colHeaders: true,
                colHeaders: ['ID', 'ID Counter', 'ID Pegawai','Tanggal', 'Counter', 'Waktu Masuk', 'Waktu Keluar'],
                contextMenu: true,
                height: 'auto',
                rowHeights: 35,
                manualRowMove: true,
                stretchH: 'all', 
                licenseKey: 'non-commercial-and-evaluation',  // for non-commercial use only
                afterChange: (changes) => {
                    changes?.forEach(([row, prop, oldVal, newVal]) => {
                        if(prop == 'counter.name'){
                            window.Livewire.dispatch('change_counter', { row : row,  name: newVal })
                        }
                    })
                },
                afterRemoveRow: (row) => {
                    deleteData(hot.getDataAtCell(row, 0))
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


    </script>

    @endvoltg
</x-layouts.app>
