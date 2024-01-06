<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, with, usesPagination, mount, on}; 
middleware(['auth']);
use App\Models\Employee;
use App\Models\Attendance;
name('human-resource.attendance.all');

usesPagination();

state([
    'perpage' => 10,
    'keyword' => '',
    'list_of_employees' => [],
    'from' => '',
    'until' => '',
    'selected_employee' => null
]);

mount(function (){
    $this->list_of_employees = Employee::where('status', true)->get();
});

with(fn() => [
    'attendances' => Attendance::when(!is_null($this->selected_employee), function($q){
        $q->where('employee_id', $this->selected_employee->id);
    })
    ->when(!empty($this->from) || !empty($this->until), function ($q){

        if(empty($this->from)){
            $q->where('created_at','<=', $this->until);
            return;
        } 

        if(empty($this->until)){
            $q->where('created_at','>=', $this->from);
            return;
        } 


        $q->whereBetween('created_at',[
            $this->from,
            $this->until,
        ]);
    })
    ->paginate($this->perpage)
]);

$get_employee = function ($id){
    $this->selected_employee = Employee::find($id);
};

$filter = function (){

};

$reset_filter = function (){
    $this->from = '';
    $this->until = '';
};

on(['getEmployee' => 'get_employee']);

?>

<x-layouts.app subheaderTitle="Absensi" >
    @volt
    <div class="container">

        <div class="row">
            <div class="col-4">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <div wire:ignore class="form-group m-0">
                            <label style="display: block;" >Pegawai </label>
                            <select wire:model="item" class="form-control" style="width: 100%;" id="select_2" >
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach ($list_of_employees as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-0">
                                    <label style="display: block;" >Dari </label>
                                    <input wire:model.live="from" type="date" class="form-control" name="" id="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-0">
                                    <label style="display: block;" >Sampai </label>
                                    <input wire:model.live="until" type="date" class="form-control" >
                                </div>
                            </div>
                            <div class="col align-self-end">
                                <button type="button" wire:click="reset_filter" class="btn btn-light btn-block">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!is_null($selected_employee))
        <div class="card card-custom mt-6">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Absensi</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered" >
                    <thead class="text-center text-uppercase" >
                        <tr>
                            <th style="vertical-align: middle;" width="50" class="" scope="col" >
                                #
                            </th>
                            <th style="vertical-align: middle;" width="200" class="" scope="col" >
                                Tanggal
                            </th>
                            <th class=" text-center" scope="col" >
                                Terlambat
                            </th>
                            <th style="vertical-align: middle;" >Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($attendances as $i => $item)
                        <tr>
                            <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                            <td style="vertical-align: middle;" >{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                            <td style="vertical-align: middle;" >{{ $item->is_late == 1 ? 'Terlambat' : '' }}</td>
                            <td>
                                <a href="/human-resource/monthly-salary/{{ $item->id }}/detail" wire:navigate class="btn btn-sm  btn-light btn-icon mr-2" title="Edit details">
                                    <span class="svg-icon svg-icon-md svg-icon-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    {{ $attendances->links('components.pagination') }}
                    
                    <div class="d-flex align-items-center py-3">
                        <select wire:model.live="perpage" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 75px;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <span class="text-muted">Menampilkan {{ $attendances->links()->paginator->count() }} dari {{  $attendances->links()->paginator->total() }} data</span>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        @else
            <div class="d-flex bg-white py-12 mt-6" >
                <span class="m-auto text-muted" >Belum ada data</span>
            </div>
        @endif
    </div>

    <script>

        document.addEventListener('livewire:navigated', () => {
            $('#select_2').select2({
                placeholder: "Pilih Pegawai"
            });
            
            $('#select_2').on('change', (e) => {
                Livewire.dispatch('getEmployee', { id: e.target.value})
            })
            
        })


    </script>

    @endvolt
</x-layouts.app>
