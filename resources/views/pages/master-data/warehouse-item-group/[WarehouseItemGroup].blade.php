<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\WarehouseItemGroupForm;
use App\Models\WarehouseItemGroup;

middleware(['auth']);
name('master-data.warehouse-item-group.edit');
form(WarehouseItemGroupForm::class);

mount(function(WarehouseItemGroup $warehouseItemGroup){
    $this->form->setModel($warehouseItemGroup);
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/master-data/warehouse-item-group', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/warehouse-item-group', navigate: true);
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
                        <label>Nama :</label>
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror" placeholder="Masukan Nama Counter"/>
                        @error('form.name')
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
                    <a href="/master-data/warehouse-item-group" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
o