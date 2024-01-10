<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, on, updated}; 
middleware(['auth']);
use App\Models\Employee;
use App\Models\MonthlySalary;
name('human-resource.monthly-salary.all');

state([
    'list_of_employees' => [],
    'from' => '',
    'until' => '',
    'selected_employee' => null,
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
});


$get_employee = function ($id){
    $this->selected_employee = $id;
    $data = MonthlySalary::with('employee')->where('monthly_salaries.employee_id', $id)
    ->get();
    Log::info(json_decode($data));
    $this->dispatch('loadData', $data);
};


$get_salaries = function (){
    $data = MonthlySalary::with('employee')->where('monthly_salaries.employee_id', $id)
    ->get();
    
    $this->dispatch('loadData', $data);
};

on(['getEmployee' => 'get_employee']);

?>

<x-layouts.app subheaderTitle="Jam Kerja" >
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
                    if(['id', 'counter_id', 'employee_id'].includes(prop)){
                        cellProperties.className = 'htMiddle htCenter';
                    }
                    return cellProperties;
                },
                filters: true,
                dropdownMenu: true,
                className: 'htMiddle ',
                columns: [
                    {
                        data: 'created_at',
                        type: 'date',
                        renderer: (instance, td, row, column, prop, value, cellProperties) => {

                            if(value == null){
                                return
                            }

                            console.log({instance, td, row, column, prop, value, cellProperties})
                            const date = new Date(value);
                            const options = { year: 'numeric', month: 'long', day: 'numeric' };
                            const formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
                            td.innerText = formattedDate
                            td.className = 'htMiddle'
                        },
                        readOnly: true
                    },
                    {
                        data: 'employee.current_salary.base_salary',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                            culture: 'id-ID'
                        },
                        readOnly: true,
                    },
                    {
                        data: 'overtime_pay',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                            culture: 'id-ID'
                        },
                        readOnly: true
                    },
                    {
                        data: 'salary_deduction',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                            culture: 'id-ID'
                        },
                        readOnly: true
                    },
                    {
                        data: 'total_salary',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                            culture: 'id-ID'
                        },
                        readOnly: true
                    },
                ],
                rowHeaders: true,
                colHeaders: true,
                colHeaders: ['Periode', 'Gaji Pokok', 'Bonus', 'Denda', 'Total Gaji'],
                contextMenu: true,
                height: 'auto',
                rowHeights: 35,
                manualRowMove: true,
                stretchH: 'all', 
                licenseKey: 'non-commercial-and-evaluation',  // for non-commercial use only
            });

            window.Livewire.on('loadData', ([ data ]) => {
                hot.loadData(data)  
            })

            
        })


    </script>

    @endvolt
</x-layouts.app>
