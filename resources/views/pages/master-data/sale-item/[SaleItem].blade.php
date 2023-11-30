<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\SaleItemForm;
use App\Models\SaleItem;
use App\Models\SaleItemGroup;

middleware(['auth']);
name('master-data.sale-item.edit');
form(SaleItemForm::class);

state(['categories']);

mount(function(SaleItem $saleItem){
    $this->form->setModel($saleItem);
    $this->categories = SaleItemGroup::all();
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/master-data/sale-item', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/sale-item', navigate: true);
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
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror"/>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kategori :</label>
                        <div></div>
                        <select wire:model="form.sale_item_group_id" class="custom-select form-control @error('form.name') is-invalid @enderror">
                            <option value="">pilih kategori</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('form.sale_item_group_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Harga:</label>
                                <input type="number" wire:model="form.price" class="form-control @error('form.price') is-invalid @enderror"/>
                                @error('form.price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Harga 2:</label>
                                <input type="number" wire:model="form.price_2" class="form-control @error('form.price_2') is-invalid @enderror"/>
                                @error('form.price_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >simpan</span>
                    </button>
                    <a href="/master-data/sale-item" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
