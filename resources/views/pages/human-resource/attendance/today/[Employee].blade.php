<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Models\Employee;
use App\Livewire\Forms\AttendanceForm;

name('human-resource.attendance.detail');
form(AttendanceForm::class);

mount(function (Employee $employee) {
    $this->form->setModel($employee);
});

?>

<x-layouts.app subheaderTitle="Detail" >
    @volt
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" value="{{ $this->form->employee->name . " ({$this->form->employee->position->name})" }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Lokasi </label>
                                    <input type="text" value="{{ $this->form->location }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Waktu Absen </label>
                                    <input type="text" value="{{ $this->form->attendance->attendance_time }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Waktu Keluar </label>
                                    <input type="text" value="{{ $this->form->attendance->attendance_time_out }}" class="form-control form-control-solid" readonly />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Keterangan </label>
                                    <input type="text" value="{{ $form->status }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <img style="height: 230px;" src="{{ url('storage/'.$form->image) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                {{-- <button type="submit" class="btn btn-primary mr-2">
                    <span wire:loading >loading</span>
                    <span wire:loading.remove >simpan</span>
                </button> --}}
                <a href="/human-resource/attendance" wire:navigate class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>