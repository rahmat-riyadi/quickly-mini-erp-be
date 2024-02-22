<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\MonthlySalary;
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

}
