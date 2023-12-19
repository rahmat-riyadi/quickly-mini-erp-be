<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\ItemCategoryForm;
use App\Models\ItemCategory;

middleware(['auth']);
name('human-resource.itemCategory.edit');
form(ItemCategoryForm::class);

mount(function(ItemCategory $itemCategory){
    $this->form->setModel($itemCategory);
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/master-data/item-category', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/item-category', navigate: true);
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
