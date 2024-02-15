<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking Attendance';

    /**
     * Execute the console command.
     */

    public function handle()
    {

        $employees = Employee::where('status', true)
        ->leftJoin('salaries as s', 's.employee_id', '=', 'employees.id')
        ->whereNotNull('s.time_off')
        ->select(
            'employees.id',
            'employees.name',
            's.time_off'
        )
        ->get();

        foreach($employees as $em){

            $this->info($em->name);

            $schedule = WorkSchedule::whereDate('date', Carbon::now())
            ->leftJoin('attendances', DB::raw('DATE(attendances.created_at)'), '=', 'work_schedules.date')
            ->select(
                'work_schedules.id',
                'work_schedules.employee_id as employee',
                'attendances.id as attendance'
            )
            ->where('work_schedules.employee_id', $em->id)
            ->first();

            if(empty($schedule)){
                continue;
            }

            $holCount = $this->getHolidayCount($em->time_off);

            $workDays = Carbon::now()->daysInMonth - $holCount;

            if(empty($schedule->attendance)){
                $a = Attendance::whereDate('created_at', '=', Carbon::now())->where('employee_id', $em->id)->first();
                if(empty($a)){
                    Attendance::create([
                        'employee_id' => $em->id,
                        'image' => '-',
                        'location' => '-',
                        'attendance_time' => '00:00',
                        'attendance_time' => '00:00',
                        'description' => 'Tidak Hadir',
                        'is_late' => 0,
                        'deduction' => $em->currentSalary->base_salary / $workDays
                    ]);
                }
            }
        }
    }

    function getHolidayCount($day){

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Inisialisasi counter jumlah hari Senin
        $count = 0;

        // Iterasi melalui setiap hari dalam bulan ini
        for ($hari = 1; $hari <= Carbon::now()->daysInMonth; $hari++) {
            $tanggal = Carbon::create($year, $month, $hari);
            
            // Memeriksa apakah hari ini adalah hari Senin (1 adalah Senin dalam format Carbon)
            if ($tanggal->dayOfWeek == $day) {
                $count++;
            }
        }

        return $count;

    }

}
