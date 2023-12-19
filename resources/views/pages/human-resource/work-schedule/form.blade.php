<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form};
use App\Livewire\Forms\WorkScheduleForm;

middleware(['auth']);
name('human-resource.work-schedule.create');
form(WorkScheduleForm::class);


$submit = function (){
    $this->validate();

    try {
        $this->form->store();
        session()->flash('success', 'Data berhasil ditambah');
        $this->redirect('');
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('');
    }

};

?>

<x-layouts.app subheaderTitle="Tambah Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card">
                <div class="card-body">
                   
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >simpan</span>
                    </button>
                    <a href="" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
