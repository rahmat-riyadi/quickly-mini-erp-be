<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\WarehouseItemForm;
use App\Models\WarehouseItem;
use App\Models\WarehouseItemGroup;

middleware(['auth']);
name('master-data.warehouse-item.edit');
form(WarehouseItemForm::class);

state(['categories']);

mount(function(WarehouseItem $warehouseItem){
    $this->form->setModel($warehouseItem);
    $this->categories = WarehouseItemGroup::all();
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/master-data/warehouse-item', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/warehouse-item', navigate: true);
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
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror" placeholder="Masukan nama item"/>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kategori :</label>
                        <div></div>
                        <select wire:model="form.warehouse_item_group_id" class="custom-select form-control @error('form.name') is-invalid @enderror">
                            <option value="">pilih kategori</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Harga Jual:</label>
                                <input type="text" wire:model="form.buy_price" class="form-control @error('form.buy_price') is-invalid @enderror" placeholder="Masukan harga"/>
                                @error('form.buy_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Harga Beli:</label>
                                <input type="text" wire:model="form.sale_price" class="form-control @error('form.sale_price') is-invalid @enderror" placeholder="Masukan harga"/>
                                @error('form.sale_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Stok :</label>
                                <input type="number" wire:model="form.stock" class="form-control @error('form.stock') is-invalid @enderror" placeholder="Masukan harga"/>
                                @error('form.stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Satuan :</label>
                                <input type="text" wire:model="form.unit" class="form-control @error('form.unit') is-invalid @enderror" placeholder="Masukan harga"/>
                                @error('form.unit')
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
                    <a href="/master-data/warehouse-item" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
