<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount, usesPagination, with}; 
use App\Models\Split;
use App\Models\Employee;
use App\Models\MonthlySalary;
use App\Models\Attendance;
middleware(['auth']);
name('human-resource.monthly-salary.index');

usesPagination();

state([
    'perpage' => 5,
    'keyword' => '',
    'start_date' => '',
    'end_date' => '',
]);


with(fn()=>[
    'employees' => Employee::with(['position', 'currentSalary'])
        ->leftJoin('monthly_salaries', function($join){
            $join->on('employees.id', '=', 'monthly_salaries.employee_id')
            ->whereMonth('monthly_salaries.created_at', '=', \Carbon\Carbon::now())
            ->whereYear('monthly_salaries.created_at', '=', \Carbon\Carbon::now());
        })
        ->where('status', true)
        ->orderBy('employees.name', 'ASC')
        ->when(!empty($this->keyword), function ($q) {
            $q->where('employees.name', 'LIKE', "%$this->keyword%");
        })
        ->select([
            'employees.id',
            'employees.name', 
            'employees.position_id', 
            'monthly_salaries.id as salary_id',
            'monthly_salaries.total_salary',
            'monthly_salaries.salary_deduction',
        ])->paginate($this->perpage),
]);

$count_salary = function (){

    $this->validate([
        'start_date' => 'required',
        'end_date' => 'required',
    ],[
        'start_date.required' => 'Tanggal mulai harus diisi',
        'end_date.required' => 'Tanggal akhir harus diisi',
    ]);

    $employees = Employee::where('status', true)->get();

    foreach($employees as $i => $employee){
        
        $salary = $employee->salary()->latest()->first();

        if(is_null($salary)){
            continue;
        }

        $attendance = Attendance::where('attendances.created_at', '>=', $this->start_date)
                    ->where('attendances.created_at', '<=', $this->end_date)
                    ->where('attendances.employee_id', '=', $employee->id)
                    ->leftJoin('overtimes', 'overtimes.attendance_id', '=', 'attendances.id')
                    ->select(
                        'attendances.id',
                        'attendances.deduction',
                        'overtimes.amount',
                    )
                    ->get();

        Log::debug($attendance->pluck('id'));

        $split_amount = Split::whereIn('attendance_id', $attendance->pluck('id'))->count();

        $total_split = $split_amount * $salary->split;

        $totalDeduction = $attendance->reduce(function($curr, $item){
            return $curr + $item['deduction'];
        });

        $totalOvertime = $attendance->reduce(function($curr, $item){
            return $curr + $item['amount'] ?? 0;
         });

        $totalSalary = $salary->base_salary - $totalDeduction + $totalOvertime + $total_split;

        $currentSalary = MonthlySalary::where('employee_id', $employee->id)
                        ->whereMonth('created_at', \Carbon\Carbon::now())
                        ->whereYear('created_at', \Carbon\Carbon::now())
                        ->first();

        if($currentSalary){
            $currentSalary->update([
                'salary_deduction' => $totalDeduction,
                'total_salary' => $totalSalary,
                'overtime_pay' => $totalOvertime,
                'split' => $total_split,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        } else {
            MonthlySalary::create([
                'employee_id' => $employee->id,
                'salary_deduction' => $totalDeduction,
                'total_salary' => $totalSalary,
                'overtime_pay' => $totalOvertime,
                'split' => $total_split,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        }

        Log::info('run calculate salary');

    }


    
};

?>

<x-layouts.app subheaderTitle="Upah Bulanan" >
    @volt
    <div class="container">

        {{-- {{ dd($employees) }} --}}

        <form wire:submit="count_salary">
            <div class="card card-custom mb-6">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col">
                            <div class="form-group m-0">
                                <label style="display: block;" >Tanggal Mulai </label>
                                <input wire:model="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" >
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group m-0">
                                <label style="display: block;" >Tanggal Akhir </label>
                                <input  wire:model="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" >
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 align-self-end">
                            <button type="submit" class="btn btn-primary btn-block">
                                Akumulasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Upah Bulanan</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="input-icon mr-5">
                        <input type="text" wire:model.live="keyword" class="form-control" placeholder="Search..."  />
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
                                Gaji Pokok
                            </th>
                            <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                Potongan
                            </th>
                            <th class=" text-center" scope="col" >
                                Total Gaji
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
                                Rp {{ number_format($item->currentSalary->base_salary ?? 0)}}
                            </td>
                            <td style="vertical-align: middle;" class="text-center" >
                                Rp {{ number_format($item->salary_deduction) ?? '' }}
                            </td>
                            <td style="vertical-align: middle;" class="text-center" >
                                Rp {{ number_format($item->total_salary) ?? '' }}
                            </td>
                            </td>
                            <td>
                                <a href="/human-resource/monthly-salary/{{ $item->salary_id }}/detail" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
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
