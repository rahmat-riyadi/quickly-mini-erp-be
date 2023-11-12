<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\ShiftTimeForm;
use App\Models\ShiftTime;

middleware(['auth']);
name('human-resource.shift-time.edit');
form(ShiftTimeForm::class);

mount(function(ShiftTime $shiftTime){
    $this->form->setModel($shiftTime);
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/human-resource/shift-time');
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/human-resource/shift-time');
    }
};

?>

<x-layouts.app subheaderTitle="Edit Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror"  />
                        @error('form.name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Dari</label>
                                <input type="time" wire:model="form.from" class="form-control @error('form.from') is-invalid @enderror"  />
                                @error('form.from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>  
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Sampai</label>
                                <input type="time" wire:model="form.until" class="form-control @error('form.until') is-invalid @enderror"  />
                                @error('form.until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >simpan</span>
                    </button>
                    <a href="/" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
