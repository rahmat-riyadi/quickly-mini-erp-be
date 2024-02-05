<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount}; 
use App\Models\MonthlySalary;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkSchedule;

middleware(['auth']);
name('human-resource.monthly-salary.all');
state(['employee', 'base_salary', 'total_revenue', 'attendance_detail', 'attendances']);

mount(function ($id){

    $monthlySalary = MonthlySalary::find($id);

    $this->employee = Employee::find($monthlySalary->employee_id);

    $this->attendances = WorkSchedule::whereBetween('date', [$monthlySalary->start_date, $monthlySalary->end_date])
                ->join('counters', 'counters.id', '=', 'work_schedules.counter_id')
                ->leftJoin('attendances', DB::raw('DATE(attendances.created_at)'), '=', 'work_schedules.date')
                ->leftJoin('overtimes', 'overtimes.attendance_id', '=', 'attendances.id')
                ->where('work_schedules.employee_id', $this->employee->id)
                ->orderBy('work_schedules.date')
                ->select(
                    'work_schedules.id',
                    'work_schedules.date',
                    'counters.name as counter',
                    'attendances.id as attendance_id',
                    'attendances.is_late as late',
                    'overtimes.start_time as overtime_start',
                    'overtimes.end_time as overtime_end',
                    'attendances.deduction as deduction',
                )
                ->get();

    Log::info(json_decode($this->attendances));

    $work_schedules = WorkSchedule::whereMonth('date', \Carbon\Carbon::now())
                ->whereYear('date', \Carbon\Carbon::now())
                ->where('employee_id',$this->employee->id)
                ->get()->toArray();


    // $a = $attendances->map(function($attendance) use ($work_schedules) {
    //     return $attendance;
    // });

    // $b = collect(array_column($attendances->toArray(), 'created_at'))->map(function($c){
    //     return \Carbon\Carbon::parse($c)->format('Y-m-d');
    // });

    // Log::info($b);


    // Log::info(json_decode($a));
    // Log::info($work_schedules);
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
                            <table>
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
                            <table style="margin-top: 40px; width: 100%;" >
                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Insentif</td>
                                        <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Lembur & Bonus</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-light" style="height: 33px;" >
                                        <td>Kehadiran</td>
                                        <td style="text-align: end; padding-right: 10px;" >Rp 210,000</td>
                                        <td>Lembur Biasa</td>
                                        <td>213123</td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td>Transport</td>
                                        <td style="text-align: end; padding-right: 10px;" >Rp 50,000</td>
                                        <td>Lembur Tanggal Merah</td>
                                        <td>213123</td>
                                    </tr>
                                    <tr class="bg-light" style="height: 33px;" >
                                        <td>Split</td>
                                        <td style="text-align: end; padding-right: 10px;" >Rp 150,000</td>
                                        <td>Lembur Fix</td>
                                        <td>213123</td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td></td>
                                        <td style="text-align: end; padding-right: 10px;" ></td>
                                        <td>Bonus</td>
                                        <td>213123</td>
                                    </tr>
                                    <tr class="bg-light" style="height: 33px;" >
                                        <td></td>
                                        <td style="text-align: end; padding-right: 10px;" ></td>
                                        <td>THR</td>
                                        <td>213123</td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td><b>Total</b></td>
                                        <td style="text-align: end; padding-right: 10px;" ><b>Rp 200,000</b></td>
                                        <td><b>Total</b></td>
                                        <td ><b>Rp 200,000</b></td>
                                    </tr>
                                    <tr style="height: 10px;" >
                                        <td colspan="4" ></td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td colspan="2" style="font-weight: 600; font-size: 16px;" >Potongan</td>
                                        <td colspan="2" ></td>
                                    </tr>
                                    <tr class="bg-light" style="height: 33px;" >
                                        <td>Terlambat</td>
                                        <td style="text-align: end; padding-right: 10px;" >213123</td>
                                        <td colspan="2" ></td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td>Denda</td>
                                        <td style="text-align: end; padding-right: 10px;" >213123</td>
                                        <td colspan="2" ></td>
                                    </tr>
                                    <tr class="bg-light" style="height: 33px;" >
                                        <td>Absen</td>
                                        <td style="text-align: end; padding-right: 10px;" >213123</td>
                                        <td colspan="2" ></td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td colspan="2" ></td>
                                        <td ><b>Gaji</b> Pokok</td>
                                        <td><b>2,000,000</b></td>
                                    </tr>
                                    <tr style="height: 33px;" >
                                        <td colspan="2" ></td>
                                        <td ><b>Gaji</b> Bersih</td>
                                        <td><b>2,000,000</b></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <table style="margin-top: 120px; width: 100%;" >
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
                    <div class="tab-pane" id="detail" role="tabpanel" >
                        <table class="table table-bordered" >
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
                                        Split
                                    </th>
                                    <th class=" text-center" scope="col" >
                                        Potongan
                                    </th>
                                    <th style="vertical-align: middle;" >Aksi</th>
                                </tr>
                                <tbody class="text-center" >
                                    @foreach ($attendances as $i => $attendance)
                                        <tr>
                                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                                            <td style="vertical-align: middle;" >{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->counter }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->attendance_id ? 'Hadir' : 'Tidak Hadir' }}</td>
                                            <td style="vertical-align: middle;" >{{ (boolean)$attendance->late ? 'Terlambat' : '' }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->overtime_start . ' - '. $attendance->overtime_end }}</td>
                                            {{-- <td style="vertical-align: middle;" >{{ $attendance-> }}</td> --}}
                                            <td style="vertical-align: middle;" >{{ $attendance->deduction }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->deduction }}</td>
                                            <td style="vertical-align: middle;" >{{ $attendance->deduction }}</td>
                                        </tr>
                                    @endforeach
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