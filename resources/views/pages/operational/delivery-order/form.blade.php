<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\DeliveryOrderForm;
use App\Models\Item;

middleware(['auth']);
name('operational.delivery-order.create');
form(DeliveryOrderForm::class);

state([
    'items' => [],
    'item' => null,
    'quantity' => 0
]);

mount(function(){
    $this->items = Item::all();
});


$submit = function (){
    $this->validate();

    try {
        $this->form->store();
        session()->flash('success', 'Data berhasil ditambah');
        $this->redirect('/operational/delivery-order', navigate: true);
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/operational/delivery-order', navigate: true);
    }

};

?>

<x-layouts.app subheaderTitle="Tambah Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Delivery Order
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                   <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nomor DO :</label>
                                <input type="text" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Counter :</label>
                                <input type="text" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
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
                                <label>Tanggal Order :</label>
                                <input type="date" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Tanggal Kirim :</label>
                                <input type="date" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
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
                                <label>Waktu Order :</label>
                                <input type="time" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Waktu Kirim :</label>
                                <input type="time" wire:model="form.do_number" class="form-control @error('form.do_number') is-invalid @enderror" />
                                @error('form.do_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                   </div>
                </div>
            </div>

            <div class="card card-custom my-8 pb-0">
                <div class="card-body">
                    <form wire:submit="addItem">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label style="display: block;" >Item Order :</label>
                                    <select wire:model="item" class="form-control" style="width: 100%;" id="select_2" >
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label style="display: block;" >Jumlah  :</label>
                                    <input type="number" wire:model="quantity" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-2 align-self-center">
                                <button type="submit"  class="btn btn-primary btn-block">
                                    Tambah 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Delivery Order Item
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($form->items as $i => $item)
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label style="display: block;" >Barang  :</label>
                                <input type="text" readonly value="{{ $item['name'] ?? '' }}" class="form-control form-control-solid "/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Jumlah :</label>
                                <input wire:change="handleChangeQuantity({{ $i }}, $event.target.value)" type="number" value="{{ $item['quantity'] ?? 0 }}" class="form-control @error('form.name') is-invalid @enderror"/>
                            </div>
                        </div>
                        <div class="col-1 align-self-center">
                            <a href="javascript:;" wire:click="handleRemoveItem({{ $i }})" class="btn btn-icon btn-light-danger">
                                <i class="flaticon2-rubbish-bin"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer text-right">
                    <button wire:loading.attr="disabled" wire:target="submit" type="submit" class="btn btn-primary mr-2">
                        Simpan
                    </button>
                    <a href="/operational/delivery-order" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
