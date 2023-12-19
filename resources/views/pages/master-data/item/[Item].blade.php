<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\ItemForm;
use App\Models\Item;
use App\Models\ItemCategory;

middleware(['auth']);
name('master-data.item.edit');
form(ItemForm::class);

state(['categories']);
mount(function(Item $item){
    $this->form->setModel($item);
    $this->categories = ItemCategory::all();
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/master-data/item', naviate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/master-data/item', naviate: true);
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
                        <select wire:model="form.category_id" class="custom-select form-control @error('form.category_id') is-invalid @enderror">
                            <option value="" >-- pilih kategori --</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('form.category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Satuan :</label>
                        <input type="text" wire:model="form.unit" class="form-control @error('form.unit') is-invalid @enderror"/>
                        @error('form.unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Konversi 1 :</label>
                                <input type="text" wire:model="form.convertion_1" class="form-control @error('form.convertion_1') is-invalid @enderror"/>
                                @error('form.convertion_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Konversi 2 :</label>
                                <input type="text" wire:model="form.convertion_2" class="form-control @error('form.convertion_2') is-invalid @enderror"/>
                                @error('form.convertion_2')
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
                                <label>Harga Beli :</label>
                                <input type="number" wire:model="form.buy_price" class="form-control @error('form.buy_price') is-invalid @enderror"/>
                                @error('form.buy_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Harga Jual :</label>
                                <input type="number" wire:model="form.sale_price" class="form-control @error('form.sale_price') is-invalid @enderror"/>
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
                                <label>Stok Awal :</label>
                                <input type="number" wire:model="form.initial_stock" class="form-control @error('form.initial_stock') is-invalid @enderror"/>
                                @error('form.initial_stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Stok Minimum :</label>
                                <input type="number" wire:model="form.minimum_stock" class="form-control @error('form.minimum_stock') is-invalid @enderror"/>
                                @error('form.minimum_stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Stok Rata Rata :</label>
                                <input type="number" wire:model="form.average_stock" class="form-control @error('form.average_stock') is-invalid @enderror"/>
                                @error('form.average_stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jenis :</label>
                        <select wire:model="form.type" class="custom-select form-control @error('form.type') is-invalid @enderror">
                            <option value="" >-- pilih jenis item --</option>
                            <option value="Production">Production</option>
                            <option value="Warehouse">Warehouse</option>
                        </select>
                        @error('form.type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status :</label>
                        <select wire:model="form.status" class="custom-select form-control @error('form.status') is-invalid @enderror">
                            <option value="" >-- pilih status --</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                        @error('form.status')
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
                    <a href="/" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
