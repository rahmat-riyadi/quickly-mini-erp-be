<?php
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, on, updated, form}; 
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkSchedule;
use App\Livewire\Forms\MonthlySalaryForm;
middleware(['auth']);
name('human-resource.monthly-salary.input');
state(['employees', 'year', 'month', 'employee', 'base_salary', 'attendance_insentive', 'split', 'transport']);

form(MonthlySalaryForm::class);

mount(function (){
    $this->employees = Employee::all();
    $this->year = \Carbon\Carbon::now()->format('Y');
});

$get_employee = function () {

    $this->validate([
        'employee' => 'required',
        'month' => 'required',
        'year' => 'required'
    ],[
        'month.required' => 'Bulan harus diisi',
        'year.required' => 'Tahun harus diisi',
        'employee.required' => 'Pegawai harus diisi'
    ]);

    $data = WorkSchedule::where('work_schedules.employee_id',$this->employee->id)
    ->whereYear('work_schedules.created_at', $this->year)
    ->whereMonth('work_schedules.created_at', $this->month)
    ->join('counters as att_c', 'att_c.id', '=', 'work_schedules.counter_id')
    ->leftJoin('attendances', DB::raw('DATE(attendances.created_at)'), '=', 'work_schedules.date')
    ->leftJoin('splits', function ($q){
        $q->on('splits.attendance_id', '=', 'attendances.id')
        ->join('counters as split_c', 'split_c.id', '=', 'splits.counter_id');
    })
    ->leftJoin('overtimes', 'overtimes.attendance_id', '=', 'attendances.id')
    ->select(
        'work_schedules.id',
        'work_schedules.date',
        'att_c.name as counter',
        'attendances.description as description',
        'attendances.is_late as late',
        'attendances.attendance_time',
        'attendances.attendance_time_out',
        'overtimes.start_time as overtime_start',
        'overtimes.end_time as overtime_end',
        'overtimes.amount as overtime_amount',
        DB::raw('CONCAT(TIMESTAMPDIFF(HOUR, overtimes.start_time, overtimes.end_time), " Jam") AS difference'),
        DB::raw('
            ROUND((
                (
                    SELECT base_salary FROM salaries WHERE employee_id = work_schedules.employee_id
                ) / 173 * (SELECT multiplier FROM overtime_masters WHERE id = overtimes.overtime_master_id)
            )  
            * 
        FLOOR(TIMESTAMPDIFF(MINUTE, overtimes.start_time, overtimes.end_time) / 60), 0) as overtime_salary'
        ),
        'attendances.deduction as deduction',
        'split_c.name as counter_split',
    )
    ->get();

    $this->form->overtime_pay = $data->reduce(function ($prev, $curr){
        return $curr->overtime_salary ?? 0 + $prev;
    }, 0);

    $this->form->salary_deduction = $data->reduce(function ($prev, $curr){
        return $curr->deduction ?? 0 + $prev;
    }, 0);

    $this->dispatch('load-data',$data);

};

$set_employee = function ($id){
    $this->employee = Employee::find($id);
    $salary =  $this->employee->currentSalary;
    $this->base_salary = $salary->base_salary;
    $this->attendance_insentive = $salary->attendance_insentive;
    $this->split = $salary->split;
    $this->transport = $salary->transport;
};

on(['set-employee' => 'set_employee'])

?>

<x-layouts.app subheaderTitle="Input Data Upah" >
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    @volt
    <div class="container" >
        <form wire:submit="get_employee">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div wire:ignore class="form-group m-0">
                                <label style="display: block;" >Pegawai </label>
                                <select wire:model="item" class="form-control" style="width: 100%;" id="select_2" >
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach ($employees as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('employee')
                                <span style="font-size: 12px;" class="text-danger" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-group m-0">
                                <label>Tahun </label>
                                <input wire:model="year" type="number" class="form-control @error('year') is-invalid @enderror">
                                @error('year')
                                <span class="invalid-feedback" >{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group m-0">
                                <label>Bulan </label>
                                <select wire:model="month" class="form-control @error('month') is-invalid @enderror" >
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Maret', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $item)
                                    <option value="{{ $i+1 }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('month')
                                <span class="invalid-feedback" >{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 align-self-end">
                            <button type="submit" type="button" class="btn btn-primary btn-block" >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="card card-custom my-6">
            <div wire:ignore class="card-body">
                {{-- <div id="excel-container"></div> --}}
                <div id="myGrid" class="ag-theme-alpine" style="height: 350px"></div>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Split</label>
                            <input value="Rp. {{ number_format($split) }}" type="text" class="form-control form-control-solid" readonly >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Transport</label>
                            <input value="Rp. {{ number_format($transport) }}" type="text" class="form-control form-control-solid" readonly >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Insentive Kehadiran</label>
                            <input value="Rp. {{ number_format($attendance_insentive) }}" type="text" class="form-control form-control-solid" readonly >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Gaji Pokok</label>
                            <input value="Rp. {{ number_format($base_salary) }}" type="text" class="form-control form-control-solid" readonly >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Uang Lembur</label>
                            <input wire:model="form.overtime_pay" type="number" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Split</label>
                            <input wire:model="form.split" type="number" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Potongan</label>
                            <input wire:model="form.salary_deduction" type="number" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-4 ">
                        <div class="form-group">
                            <label for="">Bonus</label>
                            <input wire:model="form.bonus" type="number" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">THR</label>
                            <input wire:model="form.thr" type="number" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-5 offset-7">
                        <div class="form-group row">
                            <label class="col-3 align-self-center mb-0" for="">Gaji Bersih</label>
                            <div class="col" >
                                <input type="text" class="form-control"  >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary mr-4">
                Simpan
            </button>
            <a href="/master-data/counter" wire:navigate class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    @endvolt

    <script>

        var instance

        const gridOptions = {
            rowData: [],
            columnDefs: [
                { 
                    field: "date", 
                    headerName: 'Tanggal', 
                    pinned: 'left', 
                    cellDataType: 'date',
                },
                { field: "counter", headerName: 'Counter', width: 120 },
                { field: "attendance_time", headerName: 'Waktu Masuk', width: 140 },
                { field: "attendance_time_out", headerName: 'Waktu Keluar', width: 140 },
                { 
                    field: "late", 
                    headerName: 'Terlambat', 
                    width: 120, 
                },
                { 
                    field: "deduction", 
                    headerName: 'potongan', 
                    width: 120,
                    cellRenderer: params => {
                        return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2, 
                        }).format(params.value);
                    }
                },
                { field: "overtime_start", headerName: 'Mulai Lembur', width: 140 },
                { field: "overtime_end", headerName: 'Selesai Lembur', width: 140 },
                { field: "difference", headerName: 'Lama Lembur', width: 140 },
                { 
                    field: "overtime_salary", 
                    headerName: 'Uang Lembur', 
                    width: 140,
                    cellRenderer: params => {
                        return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2, 
                        }).format(params.value);
                    }
                },
                { field: "counter_split", headerName: 'Split', width: 140 },
            ],
            pinnedBottomRowData: []
        }

        const myGridElement = document.querySelector('#myGrid');
        instance = agGrid.createGrid(myGridElement, gridOptions);

        window.addEventListener('livewire:navigated', () => {
        
            $('#select_2').select2({
                placeholder: "Pilih Pegawai"
            });
        
            $('#select_2').on('change', (e) => {
                Livewire.dispatch('set-employee', { id: e.target.value})
            })
        
            Livewire.on('load-data', ([ data ]) => {
                console.log(data)
        
                var newData = data.map(e => {

                    var overtimeDifference = 0
        
                    const date = new Date(e.date)

                    return {
                        ...e,
                        late: e.late == 1,
                        date
                    }
        
                })

                const sumData = {
                    overtime_salary: newData.reduce((prev, curr) => {
                        return curr.overtime_salary + prev
                    }, 0),
                    counter_split: newData.reduce((prev, curr) => {
                        if(curr.counter_split){
                            return prev + 1
                        }
                        return prev + 0
                    }, 0),
                    deduction: newData.reduce((prev, curr) => {
                        return curr.deduction + prev
                    }, 0)
                }

                instance.setGridOption('rowData',newData)
                instance.setGridOption('pinnedBottomRowData',[ sumData ])
        
            })
        
        })
    </script>

    <script>
    </script>
</x-layouts.app>