<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form};
use App\Livewire\Forms\DeliveryOrderForm;

middleware(['auth']);
name('operational.delivery-order.create');
form(DeliveryOrderForm::class);


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

            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Delivery Order Item
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                   
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >simpan</span>
                    </button>
                    <a href="/operational/delivery-order" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
