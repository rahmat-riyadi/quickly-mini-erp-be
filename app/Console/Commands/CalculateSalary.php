<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\MonthlySalary;
use App\Models\Split;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate-salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculating monthly salary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::where('status', true)->get();

        // $this->info($employees);

        foreach($employees as $i => $employee){
        
            $salary = $employee->salary()->latest()->first();
    
            if(is_null($salary)){
                continue;
            }

            $attendance = WorkSchedule::whereBetween('work_schedules.date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
            ->leftJoin('attendances', DB::raw('DATE(attendances.created_at)'), '=', DB::raw('DATE(work_schedules.date)'))
            ->leftJoin('overtimes', 'overtimes.attendance_id', '=', 'attendances.id')
            ->where('attendances.employee_id', '=', $employee->id)
            ->select(
                'work_schedules.id',
                'attendances.id as attendance_id',
                'attendances.deduction',
                'overtimes.amount',
            )
            ->get();

            if(count($attendance) == 0) continue;
            
            $split_amount = Split::whereIn('attendance_id', $attendance->pluck('attendance_id'))->count();
    
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
                    'start_date' => Carbon::now()->startOfMonth(),
                    'end_date' => Carbon::now()->endOfMonth(),
                ]);
            } else {
                MonthlySalary::create([
                    'employee_id' => $employee->id,
                    'salary_deduction' => $totalDeduction,
                    'total_salary' => $totalSalary,
                    'overtime_pay' => $totalOvertime,
                    'split' => $total_split,
                    'start_date' => Carbon::now()->startOfMonth(),
                    'end_date' => Carbon::now()->endOfMonth(),
                ]);
            }
    
            
    
        }
    }
}
