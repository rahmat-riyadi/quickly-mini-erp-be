<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount}; 
use App\Models\MonthlySalary;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkSchedule;
use App\Models\OvertimeMaster;
use App\Models\Overtime;

middleware(['auth']);
name('human-resource.monthly-salary.all');
state(['employee', 'base_salary', 'total_revenue', 'attendance_detail', 'attendances', 'attendances_count', 'late_count', 'overtime_total', 'deduction_total', 'overtime_summary', 'monthly_salary']);

mount(function ($id){

    $monthlySalary = MonthlySalary::find($id);

    $this->monthly_salary = $monthlySalary;

    $this->employee = Employee::find($monthlySalary->employee_id);

    $this->attendances = WorkSchedule::whereBetween('date', [$monthlySalary->start_date, $monthlySalary->end_date])
                ->join('counters as att_c', 'att_c.id', '=', 'work_schedules.counter_id')
                ->leftJoin('attendances', DB::raw('DATE(attendances.created_at)'), '=', 'work_schedules.date')
                ->leftJoin('splits', function ($q){
                    $q->on('splits.attendance_id', '=', 'attendances.id')
                    ->join('counters as split_c', 'split_c.id', '=', 'splits.counter_id');
                })
                ->leftJoin('overtimes', 'overtimes.attendance_id', '=', 'attendances.id')
                ->where('work_schedules.employee_id', $this->employee->id)
                ->orderBy('work_schedules.date')
                ->select(
                    'work_schedules.id',
                    'work_schedules.date',
                    'att_c.name as counter',
                    'attendances.description as description',
                    'attendances.is_late as late',
                    'overtimes.start_time as overtime_start',
                    'overtimes.end_time as overtime_end',
                    'overtimes.amount as overtime_amount',
                    'attendances.deduction as deduction',
                    'split_c.name as counter_split',
                )
                ->get();

    $work_schedules = WorkSchedule::whereMonth('date', \Carbon\Carbon::now())
                ->whereYear('date', \Carbon\Carbon::now())
                ->where('employee_id',$this->employee->id)
                ->get()->toArray();

    $this->attendances_count = $this->attendances->reduce(function ($prev, $curr) {
        if(!is_null($curr['attendance_id']))
            return $prev + 1;
        else
            return $prev;
    }, 0);

    $this->late_count = $this->attendances->reduce(function ($prev, $curr) {
        if((boolean)$curr['late'])
            return $prev + 1;
        else
            return $prev;
    }, 0);

    $this->overtime_total = $this->attendances->reduce(function ($prev, $curr) {
        return $prev + $curr['overtime_amount'] ?? 0;
    }, 0);

    $this->deduction_total = $this->attendances->reduce(function ($prev, $curr) {
        return $prev + $curr['deduction'] ?? 0;
    }, 0);

    $this->overtime_summary = Overtime::whereIn('overtimes.attendance_id', $this->attendances->pluck('attendance_id'))
    ->join('overtime_masters as o', 'o.id', '=', 'overtimes.overtime_master_id')
    ->groupBy('o.id', 'o.name')
    ->select(
        'o.name',
        DB::raw('SUM(overtimes.amount) as total')
    )
    ->get();

});

?>

<x-layouts.app subheaderTitle="Detail" >
    @volt
    <div class="container">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="text-center" ><u>Slip Gaji Karyawan</u></h4>
                <p class="text-center" >Periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                <div class="px-8">
                    <table >
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>NIK</b></td>
                            <td>: {{ $employee->nik }}</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Nama</b></td>
                            <td>: {{ $employee->name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Jabatan</b></td>
                            <td>: {{ $employee->position->name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Status</b></td>
                            <td>: Karyawan Tetap</td>
                        </tr>
                    </table>
                    <div class="d-flex" style="margin-top: 40px;" >
                        <table style="width: 50%;" class="table-striped" >
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Insentif</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 33px;" >
                                    <td>Kehadiran</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp 210,000</td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td>Transport</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp 50,000</td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td>Split</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp 150,000</td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td><b>Total</b></td>
                                    <td style="text-align: end; padding-right: 10px;" ><b>Rp 200,000</b></td>
                                </tr>
                                
                            </tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                        <table class="table-striped" style="width: 50%; height: fit-content;" >
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Insentif</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overtime_summary as $i => $item)
                                    <tr style="height: 33px;" >
                                        <td>{{ $item->name }}</td>
                                        <td style="text-align: end; padding-right: 10px;" >Rp {{ number_format($item->total) }}</td>
                                    </tr>
                                @endforeach
                                @for ($i = 0; $i < 5 - count($overtime_summary); $i++)
                                <tr  style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                @endfor
                                <tr style="height: 33px;" >
                                    <td><b>Total</b></td>
                                    <td style="text-align: end; padding-right: 10px;" ><b>Rp {{ number_format($overtime_total) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex" style="margin-top: 20px;" >
                        <table style="width: 50%; height: fit-content;" class="table-striped" >
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Potongan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 33px;" >
                                    <td>Terlambat</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp {{ number_format($deduction_total) }}</td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td>Denda</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp 0</td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td>Absen</td>
                                    <td style="text-align: end; padding-right: 10px;" >Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 50%;" class="table-striped" >
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%; color: transparent;" >-</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                <tr style="height: 33px;" >
                                    <td></td>
                                    <td style="text-align: end; padding-right: 10px;" ></td>
                                </tr>
                                <tr class="" style="height: 33px;" >
                                    <td> <span class="font-weight-bolder" >Gaji</span> Pokok</td>
                                    <td style="text-align: end; padding-right: 10px;" >{{ number_format($employee->currentSalary->base_salary) }}</td>
                                </tr>
                                <tr class="" style="height: 33px;" >
                                    <td> <span class="font-weight-bolder" >Gaji</span> Bersih</td>
                                    <td style="text-align: end; padding-right: 10px;" >{{ number_format($monthly_salary->total_salary) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <table style="margin-top: 120px; width: 100%;" class="table-striped" >
                        <tr>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Personalia</p>
                            </td>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Penerima</p>
                            </td>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Pembukan</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> --}}
        <div class="card card-custom overflow-hidden">
            <div class="card-body p-0">
                <!-- begin: Invoice-->
                <!-- begin: Invoice header-->
                <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                            <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                            <div class="d-flex flex-column align-items-md-end px-0">
                                <!--begin::Logo-->
                                <a href="#" class="mb-5">
                                    <img src="assets/media/logos/logo-dark.png" alt="" />
                                </a>
                                <!--end::Logo-->
                                <span class="d-flex flex-column align-items-md-end opacity-70">
                                    <span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
                                    <span>Mississippi 96522</span>
                                </span>
                            </div>
                        </div>
                        <div class="border-bottom w-100"></div>
                        <div class="d-flex justify-content-between pt-6">
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">Nama</span>
                                <span class="opacity-70">{{ $employee->name }}</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">Jabatan</span>
                                <span class="opacity-70">{{ $employee->position->name }}</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">Alamat</span>
                                <span class="opacity-70">{{ $employee->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice header-->
                <!-- begin: Invoice body-->
                <div class="row justify-content-center py-3 px-8 py-md-8 px-md-0">
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">Deskripsi</th>
                                        {{-- <th class="text-right font-weight-bold text-muted text-uppercase">Jam</th> --}}
                                        {{-- <th class="text-right font-weight-bold text-muted text-uppercase">Rate</th> --}}
                                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-weight-bold">
                                        <td class="pl-0 pt-7">Intensive Kehadiran</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="text-right pt-7">{{ number_format($employee->currentSalary->attendance_intensive) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    @foreach ($overtime_summary as $item)
                                    <tr class="font-weight-bold border-bottom-0">
                                        <td class="border-top-0 pl-0 py-4">Lembur</td>
                                        {{-- <td class="border-top-0 text-right py-4">210</td> --}}
                                        <td class="border-top-0 text-right py-4">$60.00</td>z
                                        {{-- <td class="text-danger border-top-0 pr-0 py-4 text-right">$12600.00</td> --}}
                                    </tr>
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">Split</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($monthly_salary->split) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">Lembur</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($monthly_salary->overtime_pay) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">Bonus</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($monthly_salary->bonus) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">THR</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($monthly_salary->thr) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">Potongan</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($monthly_salary->salary_deduction + $monthly_salary->fine) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td class="border-top-0 pl-0 py-4">Gaji Pokok</td>
                                        {{-- <td class="text-right pt-7">0</td> --}}
                                        <td class="border-top-0 text-right py-4">Rp {{ number_format($employee->currentSalary->base_salary) }}</td>
                                        {{-- <td class="text-danger pr-0 pt-7 text-right">$3200.00</td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice body-->
                <!-- begin: Invoice footer-->
                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold text-muted text-uppercase">Personalia</th>
                                        <th class="font-weight-bold text-muted text-uppercase">Penerima</th>
                                        <th class="font-weight-bold text-muted text-uppercase">Tanggal</th>
                                        <th class="font-weight-bold text-muted text-uppercase">TOTAL GAJI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-weight-bolder">
                                        <td>A Muliati</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ Carbon\Carbon::now()->translatedFormat('F 05, Y') }}</td>
                                        <td class="text-danger font-size-h3 font-weight-boldest">{{ number_format($monthly_salary->total_salary) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice footer-->
                <!-- begin: Invoice action-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button>
                            <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice action-->
                <!-- end: Invoice-->
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>