<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, form, on, mount}; 
use App\Livewire\Forms\DeliveryOrderForm;
use App\Events\SendDoNotification;
use App\Models\Item;
middleware(['auth']);
form(DeliveryOrderForm::class);
name('counter.delivery-order.create');

state([
    'items' => [],
    'item' => null,
    'quantity' => 0
]);

mount(function(){
    $this->items = Item::all();
});

on(['setItem' => function($val){
    $this->item = $val;
}]);

$addItem = function (){
$this->form->addItem(
        id: $this->item,
        quantity: $this->quantity,
    );
    $this->reset(['item', 'quantity']);
    $this->dispatch('hide-modal');
};

$handleChangeQuantity = function ($idx, $val){
    $this->form->changeQuantity($idx, $val);
};

$handleRemoveItem = function ($idx){
    $this->form->removeItem($idx);
};

$handleStore = function (){

    try {
        $this->form->store();
        $this->redirect('/counter/delivery-order', navigate: true);
    } catch (\Throwable $th) {
        Log::debug($th->getMessage());
    }

};

?>

<x-layouts.app subheaderTitle="Buat DO" >
    @volt
    <div class="container">
        <div class="card-custom card">
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
                            <label>Tanggal Order :</label>
                            <input type="date" wire:model="form.order_date" class="form-control @error('form.order_date') is-invalid @enderror"/>
                            @error('form.order_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">

                        <div class="form-group">
                            <label>Jam Order :</label>
                            <input type="time" wire:model="form.order_time" class="form-control @error('form.order_time') is-invalid @enderror"/>
                            @error('form.order_time')
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
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Daftar Barang
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
                <button wire:loading.attr="disabled" type="button" wire:click="handleStore" class="btn btn-primary mr-2">
                    Simpan
                </button>
                <a href="/counter/delivery-order" wire:navigate class="btn btn-secondary">Kembali</a>
            </div>
        </div>
        
        {{-- <div wire:ignore >
            <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form wire:submit="addItem" >
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label style="display: block;" >Item Order :</label>
                                    <select wire:model="item" class="form-control" style="width: 100%;" id="select_2" >
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display: block;" >Item Order :</label>
                                    <input wire:model="quantity" type="number" class="form-control" >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary font-weight-bold">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <script>

        document.addEventListener('livewire:navigated', () => {
            $('#select_2').select2({
                placeholder: "Pilih Barang"
            });
            
            $('#select_2').on('change', (e) => {
                Livewire.dispatch('setItem', { val: e.target.value})
            })
            
            Livewire.on('hide-modal', () => {
                $('#itemModal').modal('hide');
            })
        })


    </script>


    @push('script')
        <script>
    
    

        </script>
    @endpush

    @endvolt
</x-layouts.app>