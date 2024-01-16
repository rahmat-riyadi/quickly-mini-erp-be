<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, on, updated}; 
middleware(['auth']);
use App\Models\Employee;
use App\Models\Salary;
name('human-resource.monthly-salary.master');

state([
    'list_of_employees' => [],
    'selected_employee' => null,
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
});


$get_employee = function ($id){
    $this->selected_employee = $id;
    $data = Salary::where('employee_id', $id)->get();
    if(count($data) == 0){
        $this->dispatch('loadData', [
            ...$data, 
            [
                'id' => null,
                'employee_id' => $id,
                'base_salary' => null,
                'attendance_intensive' => null,
                'split' => null,
                'transport' => null
            ]
        ]);
    } else {
        $this->dispatch('loadData', $data);
    }
};


$get_salaries = function (){
    $data = Salary::where('employee_id', $this->selected_employee)->get();
    $this->dispatch('loadData', $data);
};

on(['getEmployee' => 'get_employee']);
on(['getSalaries' => 'get_salaries']);

?>

<x-layouts.app subheaderTitle="Data Master Upah" >
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

            function saveSalary(data){
                $.ajax({
                    url: "{{ route('salary.store') }}",
                    method: 'POST',
                    data: {
                        salaries: data
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
                        window.Livewire.dispatch('getSalaries')
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
                    url: '/human-resource/salary/delete/' + id,
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: res => console.log(res),
                    error: err => console.log(err),
                })
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
                    if(['id', 'counter_id', 'employee_id'].includes(prop)){
                        cellProperties.className = 'htMiddle htCenter';
                    }
                    return cellProperties;
                },
                hiddenColumns: {
                    columns: [0,1]
                },
                filters: true,
                dropdownMenu: true,
                className: 'htMiddle ',
                columns: [
                    {
                        data: 'id',
                        readOnly: true,
                    },
                    {
                        data: 'employee_id',
                        readOnly: true,
                    },
                    {
                        data: 'base_salary',
                        type: 'numeric',  
                        numericFormat: {
                            pattern: '000,000',
                        }
                    },
                    {
                        data: 'attendance_intensive',
                        type: 'numeric',  
                        numericFormat: {
                            pattern: '000,000',
                        }
                    },
                    {
                        data: 'split',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                        },
                    },
                    {
                        data: 'transport',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '000,000',
                        },
                    }
                ],
                rowHeaders: true,
                colHeaders: true,
                colHeaders: ['id', 'id pegawai','Gaji Pokok', 'Intensive Kehadiran', 'Split', 'Transport'],
                contextMenu: true,
                height: 'auto',
                rowHeights: 35,
                manualRowMove: true,
                stretchH: 'all', 
                licenseKey: 'non-commercial-and-evaluation',  // for non-commercial use only
                afterCreateRow: (index, amout) => {
                    hot.setDataAtCell(
                        index, 
                        1, 
                        hot.getDataAtCell(index == 0 ? 1 : index-1,1)
                    )
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

            document.querySelector('.save').addEventListener('click', () => {
                saveSalary(hot.getData())
            })

            
        })


    </script>

    @endvolt
</x-layouts.app>
