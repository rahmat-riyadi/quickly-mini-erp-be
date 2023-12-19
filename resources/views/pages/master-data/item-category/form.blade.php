<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form};
use App\Livewire\Forms\ItemCategoryForm;

middleware(['auth']);
name('master-data.item-category.create');
form(ItemCategoryForm::class);


$submit = function (){
    $this->validate();

    try {
        $this->form->store();
        session()->flash('success', 'Data berhasil ditambah');
        $this->redirect('/master-data/item-category', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/item-category', navigate: true);
    }

};

?>

<x-layouts.app subheaderTitle="Tambah Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Kategori :</label>
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror"/>
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
                    <a href="/master-data/item-category" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
