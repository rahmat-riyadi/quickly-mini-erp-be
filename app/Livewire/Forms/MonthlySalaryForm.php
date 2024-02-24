<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\MonthlySalary;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MonthlySalaryForm extends Form
{
    public ?Employee $employee;
    public ?MonthlySalary $montlySalary;

    #[Rule('required', message: 'Tahun harus diisi')]
    public $year;

    #[Rule('required', message: 'Bulan harus diisi')]
    public $month;

    #[Rule('nullable')]
    public $salary_deduction;
    
    #[Rule('nullable')]
    public $split;

    #[Rule('nullable')]
    public $overtime_pay;
    
    #[Rule('required', message: 'Total gaji harus diisi')]
    public $total_salary;

    #[Rule('nullable')]
    public $bonus;

    #[Rule('nullable')]
    public $thr;

    #[Rule('nullable')]
    public $fine;

    public function store(){
        
        try {

            $monthlySalary = MonthlySalary::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->where('employee_id', $this->employee->id)->first();

            
            if(!empty($monthlySalary)){
                $monthlySalary->update([
                    'bonus' => str_replace(',', '', $this->bonus),
                    'thr' => str_replace(',', '', $this->thr),
                    'fine' => str_replace(',', '', $this->fine),
                    'total_salary' => str_replace(',', '', $this->total_salary),
                    'overtime_pay' => str_replace(',', '', $this->overtime_pay),
                    'split' => str_replace(',', '', $this->split),
                    'salary_deduction' => str_replace(',', '', $this->salary_deduction),
                ]);
                return;
            }

            MonthlySalary::create([
                'employee_id' => $this->employee->id,
                'bonus' => !empty($this->bonus) ? str_replace(',', '', $this->bonus) : 0,
                'thr' => !empty($this->thr) ? str_replace(',', '', $this->thr) : 0,
                'fine' => !empty($this->fine) ? str_replace(',', '', $this->fine) : 0,
                'total_salary' => !empty($this->total_salary) ? str_replace(',', '', $this->total_salary) : 0,
                'overtime_pay' => !empty($this->overtime_pay) ? str_replace(',', '', $this->overtime_pay) : 0,
                'split' => !empty($this->split) ? str_replace(',', '', $this->split) : 0,
                'salary_deduction' => !empty($this->salary_deduction) ? str_replace(',', '', $this->salary_deduction) : 0,
            ]);

            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function setModel(MonthlySalary $monthlySalary){
        $this->total_salary = $monthlySalary->total_salary;
        foreach($monthlySalary->only('bonus', 'fine', 'thr', 'salary_deduction', 'split', 'overtime_pay') as $i => $val){
            $this->{$i} = number_format(str_replace('.00', '', $val));
        }
    }

}
