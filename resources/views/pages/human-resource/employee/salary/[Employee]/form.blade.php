<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\SalaryForm;
use App\Models\Employee;

form(SalaryForm::class);

name('human-resource.employee.salary.create');

state(['employee']);

mount(function (Employee $employee){
    $this->employee = $employee;
    $this->form->setEmployee($employee);
});

$submit = function (){

    try {
        $this->form->store();
        session()->flash('success', 'Data berhasil ditambah');
        $this->redirect("/human-resource/employee/salary/{$this->employee->id}");
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect("/human-resource/employee/salary/{$this->employee->id}");
    }

};

?>

<x-layouts.app subheaderTitle="Upah" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Gaji Pokok :</label>
                        <input type="number" wire:model="form.base_salary" class="form-control @error('form.base_salary') is-invalid @enderror" placeholder="Masukan Gaji Pokok"/>
                        @error('form.base_salary')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Waktu Off :</label>
                        <input type="text" wire:model="form.time_off" class="form-control @error('form.time_off') is-invalid @enderror" placeholder="Masukan Waktu Off"/>
                        @error('form.time_off')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Intensive Kehadiran :</label>
                        <input type="text" wire:model="form.attendance_intensive" class="form-control @error('form.attendance_intensive') is-invalid @enderror" placeholder="Masukan Intensive Kehadiran"/>
                        @error('form.attendance_intensive')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >simpan</span>
                    </button>
                    <a href="/human-resource/employee/salary/{{ $employee->id }}" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>