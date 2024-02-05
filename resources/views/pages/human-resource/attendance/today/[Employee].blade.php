<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount, updated};
use App\Models\Employee;
use App\Models\Counter;
use App\Models\OvertimeMaster;
use App\Livewire\Forms\AttendanceForm;

name('human-resource.attendance.detail');
form(AttendanceForm::class);

state(['has_overtime', 'has_split','counter', 'overtimeMaster']);

mount(function (Employee $employee) {
    $this->overtimeMaster = OvertimeMaster::all();
    $this->counter = Counter::all();
    $this->form->setModel($employee);
    $this->has_overtime = !is_null($this->form->attendance->overtime);
    $this->has_split = !is_null($this->form->attendance->split);
});

$update = function (){

    $this->validate([
        'form.attendance_time' => 'required',
        'form.attendance_time_out' => 'nullable',
        'form.location' => 'required',
        'form.deduction' => 'required',
        'form.is_late' => 'required',
    ]);
    
    try {
        $this->form->update();
        $this->dispatch('show-notif', true, 'Data berhasil disimpan');
    } catch (\Throwable $th) {
        $this->dispatch('show-notif', false, $th->getMessage());
    }

};

$submit_overtime = function (){

    $this->validate([
        'form.overtime_type' => 'required',
        'form.start_time' => 'required',
        'form.end_time' => 'required',
    ]);
    
    try {
        $this->form->storeOvertime();
        $this->dispatch('show-notif', true, 'Data berhasil disimpan');
    } catch (\Throwable $th) {
        $this->dispatch('show-notif', false, $th->getMessage());
    }

};

$submit_split = function (){

    $this->validate([
        'form.counter_id' => 'required',
    ]);
    
    try {
        $this->form->storeSplit();
        $this->dispatch('show-notif', true, 'Data berhasil disimpan');
    } catch (\Throwable $th) {
        $this->dispatch('show-notif', false, $th->getMessage());
    }

};

$handle_change_time = function (){

    if(empty($this->form->start_time) || empty($this->form->start_time) || empty($this->form->overtime_type)){
        return;
    }

    $overtime = OvertimeMaster::find($this->form->overtime_type);

    $multiplier = 173 * $overtime->multiplier;

    $amount = $this->form->employee->currentSalary->base_salary / $multiplier;

    $to = \Carbon\Carbon::parse($this->form->start_time);
    $from = \Carbon\Carbon::parse($this->form->end_time);

    $diff = $to->diffInHours($from);

    $overtime_pay = $amount * $diff;

    Log::info($overtime_pay);
    Log::info($diff);
    Log::info($amount);

    $this->form->fill(['amount' => number_format($overtime_pay)]);

    // Log::info($this->form->start_time);
    // Log::info($this->form->end_time);
    // Log::info($this->form->overtime_type);
};

?>

<x-layouts.app subheaderTitle="Detail" >
    @volt
    <div class="container">
        <form wire:submit="update" >
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        Kehadiran
                    </div>
                </div>
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
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Keterangan </label>
                                                <input type="text" value="{{ $form->description }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Status </label>
                                                <input type="text" value="{{ $form->status }}" class="form-control form-control-solid" readonly placeholder="Masukan Nama"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Waktu Absen </label>
                                        <input type="time" wire:model="form.attendance_time" class="form-control @error('form.attendance_time') is-invalid @enderror" placeholder="Masukan Nama"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Waktu Keluar </label>
                                        <input type="time"  wire:model="form.attendance_time_out"  class="form-control @error('form.attendance_time_out') is-invalid @enderror" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Terlambat</label>
                                                <select wire:model="form.is_late" class="form-control custom-select @error('form.is_late') is-invalid @enderror">
                                                    <option value="" >-- Pilih --</option>
                                                    <option value="0" >Tidak terlambat</option>
                                                    <option value="1" >Terlambat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Potongan </label>
                                                <input type="number" wire:model="form.deduction" class="form-control @error('form.deduction') is-invalid @enderror" />
                                            </div>
                                        </div>
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
                    {{-- <a href="/human-resource/attendance" wire:navigate class="btn btn-secondary">Kembali</a> --}}
                    <button class="btn btn-primary font-weight-bold">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        <form wire:submit="submit_overtime" >
            <div class="card card-custom mt-8">
                <div class="card-header">
                    <div class="card-title">
                        Lembur
                    </div>
                </div>
                <div class="card-body">
                    @if (!$has_overtime)
                    <p class="m-0 text-center text-muted" >Tidak ada data lembur.</p>
                    @else
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Jenis Lembur</label>
                                <select wire:change="handle_change_time" wire:model="form.overtime_type" class="form-control custom-select @error('form.overtime_type') is-invalid @enderror" >
                                    <option value="" >-- Pilih Lembur --</option>
                                    @foreach ($overtimeMaster as $item)
                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('form.overtime_type')
                                    <span class="invalid-feedback" >{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Mulai Lembur</label>
                                <input wire:change="handle_change_time" wire:model="form.start_time" type="time" class="form-control  @error('form.start_time') is-invalid @enderror">
                                @error('form.start_time')
                                    <span class="invalid-feedback" >{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Akhir Lembur</label>
                                <input wire:change="handle_change_time" wire:model="form.end_time" type="time" class="form-control  @error('form.end_time') is-invalid @enderror">
                                @error('form.end_time')
                                    <span class="invalid-feedback" >{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Bayaran Lembur</label>
                                <input wire:model="form.amount" type="text" min="0" readonly class="form-control form-control-solid">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    @if ($has_overtime)
                    <button type="submit" class="btn  btn-primary font-weight-bold">
                        Simpan
                    </button>
                    @else
                    <button type="button" wire:click="$set('has_overtime', true)"  class="btn  btn-primary font-weight-bold">
                        Tambah Lembur
                    </button>
                    @endif
                </div>
            </div>
        </form>

        <form wire:submit="submit_split" >
            <div class="card card-custom mt-8">
                <div class="card-header">
                    <div class="card-title">
                        Split
                    </div>
                </div>
                <div class="card-body">
                    @if ($has_split)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Counter</label>
                                <select wire:model="form.counter_id" class="form-control custom-select">
                                    <option value="" >-- Pilih Counter --</option>
                                    @foreach ($counter as $item)
                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="m-0 text-center text-muted" >Tidak ada data split.</p>
                    @endif
                </div>
                <div class="card-footer text-right">
                    @if ($has_split)
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        Simpan
                    </button>
                    @else
                    <button type="button" wire:click="$set('has_split', true)"  class="btn  btn-primary font-weight-bold">
                        Tambah Split
                    </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>