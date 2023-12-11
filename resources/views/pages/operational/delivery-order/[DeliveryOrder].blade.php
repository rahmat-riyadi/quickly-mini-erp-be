<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\DeliveryOrderForm;
use App\Models\DeliveryOrder;

middleware(['auth']);
name('operational.delivery-order.edit');
form(DeliveryOrderForm::class);

mount(function(DeliveryOrder $deliveryOrder){
    $this->form->setModel($deliveryOrder);
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/');
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/');
    }
};

?>

<x-layouts.app subheaderTitle="Edit Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card">
                <div class="card-body">
                   
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
