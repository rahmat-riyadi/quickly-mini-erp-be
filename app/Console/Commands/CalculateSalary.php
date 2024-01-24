<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\MonthlySalary;
use Carbon\Carbon;
use Illuminate\Console\Command;
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

        foreach($employees as $i => $employee){
            
            $salary = $employee->salary()->latest()->first();

            if(is_null($salary)){
                continue;
            }

            $totalDeduction = $employee->currentMonthAttendance->reduce(function($curr, $item){
                return $curr + $item['deduction'];
            });
            
            $totalDeduction = $employee->currentMonthAttendance->reduce(function($curr, $item){
                return $curr + $item['deduction'];
            });

            $totalSalary = $salary->base_salary - $totalDeduction;

            $currentSalary = MonthlySalary::where('employee_id', $employee->id)
                            ->whereMonth('created_at', Carbon::now())
                            ->whereYear('created_at', Carbon::now())
                            ->first();

            if($currentSalary){
                $currentSalary->update([
                    'salary_deduction' => $totalDeduction,
                    'total_salary' => $totalSalary
                ]);
            } else {
                MonthlySalary::create([
                    'employee_id' => $employee->id,
                    'salary_deduction' => $totalDeduction,
                    'total_salary' => $totalSalary
                ]);
            }

            Log::info('run calculate salary');

        }
    }
}
