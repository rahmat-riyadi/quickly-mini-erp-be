<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\WorkScheduleForm;
use App\Models\Employee;
use App\Models\Counter;

middleware(['auth']);
name('human-resource.work-schedule.edit');
form(WorkScheduleForm::class);

state(['counters', 'counter']);

mount(function(Employee $employee){
    $this->counters = Counter::all();
    $this->form->setModel($employee);
});

$handleUpdateProperty = function ($id, $name, $value){
    $this->form->updateProperty($id, $name, $value);
};

$handleDeleteSchedule = function ($id){
    $this->form->deleteSchedule($id);
};

$submit = function (){

    $this->validate();

    try {
        $this->form->store();
    } catch (\Throwable $th) {
        Log::debug($th->getMessage());
    }

};

?>

<x-layouts.app subheaderTitle="Detail Jam Kerja" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >

            <div class="card card-custom mb-5">
                <div class="card-body p-4">
                    <form wire:submit="submit" >
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-0">
                                    <label>Tanggal : {{ Log::debug($form->dates) }}</label>
                                    <select wire:model="form.date" class="custom-select form-control @error('form.counter_id') is-invalid @enderror">
                                        <option value="">-- pilih hari --</option>
                                        @foreach ($form->dates as $date)
                                        <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->translatedFormat('l') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-0">
                                    <label>Counter :</label>
                                    <select wire:model="form.counter_id" class="custom-select form-control @error('form.counter_id') is-invalid @enderror">
                                        <option value="">-- pilih counter --</option>
                                        @foreach ($counters as $counter)
                                        <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-0">
                                    <label>Waktu Masuk :</label>
                                    <input type="time" wire:model="form.time_in" class="form-control @error('form.time_in') is-invalid @enderror" placeholder="Masukan Nama Counter"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-0">
                                    <label>Waktu Keluar :</label>
                                    <input type="time" wire:model="form.time_out" class="form-control @error('form.time_out') is-invalid @enderror" placeholder="Masukan Nama Counter"/>
                                </div>
                            </div>
                            <div class="col align-self-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <table style="width: 100%;" class="table table-bordered text-center">
                        <thead class="text-uppercase" >
                            <tr>
                                <th width="50" class="py-4" >#</th> 
                                <th class="py-4" >Hari</th> 
                                <th class="py-4" >Counter</th> 
                                <th class="py-4" >Waktu Masuk</th> 
                                <th class="py-4" >Waktu Keluar</th> 
                                <th></th>
                            </tr>
                        </thead>
                        <tbody  >
                            @foreach($form->employee->currentWeekSchedule as $i=> $item)
                            <tr class="" >
                                <td style="vertical-align: middle;" class="py-3 text-center" >{{ $i+1 }}</td>
                                <td style="vertical-align: middle;" class="py-3 text-center" >{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</td>
                                <td style="vertical-align: middle;" class="py-3 text-center" >
                                    <select style="width: 200px;" wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'counter_id', $event.target.value)" class="custom-select form-control @error('form.counter_id') is-invalid @enderror">
                                        <option value="">-- pilih counter --</option>
                                        @foreach ($counters as $counter)
                                            <option {{ $item->counter_id == $counter->id ? 'selected' : '' }} value="{{ $counter->id }}">{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="vertical-align: middle;" class="py-3 text-center" >
                                    <input style="width: 150px;" wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'time_in', $event.target.value)" value="{{ $item->time_in }}" type="time" class="form-control mx-auto" />  
                                </td>
                                <td style="vertical-align: middle;" class="py-3 text-center" >
                                    <input style="width: 150px;" wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'time_out', $event.target.value)" value="{{ $item->time_out }}" type="time" class="form-control mx-auto" />
                                </td>
                                <td>
                                    <button wire:click="handleDeleteSchedule({{ $item->id }})" class="btn btn-sm btn-icon btn-danger" >
                                        <i class="flaticon2-rubbish-bin" ></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- @foreach($form->employee->currentWeekSchedule as $item)
                        <div class="row">
                             <div class="col">
                                <div class="form-group">
                                    <label>Hari :</label>
                                    <input value="{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}" type="text" class="form-control form-control-solid" />
                                </div>
                             </div>
                             <div class="col">
                                <div class="form-group">
                                    <label>Counter :</label>
                                    <select wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'counter_id', $event.target.value)" class="custom-select form-control @error('form.counter_id') is-invalid @enderror">
                                        <option value="">-- pilih counter --</option>
                                        @foreach ($counters as $counter)
                                            <option {{ $item->counter_id == $counter->id ? 'selected' : '' }} value="{{ $counter->id }}">{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                             </div>
                             <div class="col">
                                <div class="form-group">
                                    <label>Waktu Masuk :</label>
                                    <input wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'time_in', $event.target.value)" value="{{ $item->time_in }}" type="time" class="form-control" />
                                </div>
                             </div>
                             <div class="col">
                                <div class="form-group">
                                    <label>Waktu Keluar :</label>
                                    <input wire:change.debounce="handleUpdateProperty({{ $item->id }} ,'time_out', $event.target.value)" value="{{ $item->time_out }}" type="time" class="form-control" />
                                </div>
                             </div>
                             <div class="col-1 align-self-center">
                                <button class="btn btn-sm btn-icon btn-danger" >
                                    <i class="flaticon2-rubbish-bin" ></i>
                                </button>
                             </div>
                        </div>
                    @endforeach --}}
                </div>
                <div class="card-footer text-right">
                    <a href="/" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <div class="sheet-container"></div>
            </div>
        </div>

    </div>


    @endvolt
</x-layouts.app>
