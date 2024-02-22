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
        <ul class="nav nav-tabs nav-tabs-line bg-white px-8 mb-3 nav-bold">
            <li class="nav-item">
                <a style="font-size: 14px;" class="nav-link active" data-toggle="tab" href="#slip_gaji">Slip Gaji</a>
            </li>
            <li class="nav-item">
                <a style="font-size: 14px;" class="nav-link" data-toggle="tab" href="#detail">Detail</a>
            </li>
        </ul>
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="slip_gaji" role="tabpanel" >
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
                    <div class="tab-pane " id="detail" role="tabpanel" >
                        <table class="table " >
                            <thead class="text-center text-uppercase" >
                                <tr>
                                    <th style="vertical-align: middle;" width="50" class="" scope="col" >
                                        #
                                    </th>
                                    <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                        Waktu
                                    </th>
                                    <th class=" text-center" scope="col" >
                                        Counter
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Status
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Terlambat
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Lembur
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Uang Lembur
                                    </th>
                                    <th style="vertical-align: middle;" class=" text-center" scope="col" >
                                        Split
                                    </th>
                                    <th class=" text-center" scope="col" >
                                        Potongan
                                    </th>
                                </tr>
                                <tbody class="text-center" >
                                    @foreach ($attendances as $i => $attendance)
                                        <tr>
                                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                                            <td style="vertical-align: middle;" >{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->counter }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->description }}</td>
                                            <td style="vertical-align: middle;" >{{ (boolean)$attendance->late ? 'Terlambat' : '' }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->overtime_start . ' - '. $attendance->overtime_end }}</td>
                                            <td style="vertical-align: middle;" >{{ number_format($attendance->overtime_amount) }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->counter_split }}</td>
                                            <td style="vertical-align: middle;" >{{ number_format($attendance->deduction) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-dark" >
                                        <td>#</td>
                                        <td colspan="" > Kehadiran : {{ $attendances_count }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>Terlambat : {{ $late_count }}</td>
                                        <td></td>
                                        <td>{{ number_format($overtime_total) }}</td>
                                        <td></td>
                                        <td>{{ number_format($deduction_total) }}</td>
                                    </tr>
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>