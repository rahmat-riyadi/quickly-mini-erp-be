<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\DeliveryOrderForm;
use App\Models\DeliveryOrder;

middleware(['auth']);
name('counter-menu.delivery-order.edit');
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


$handleChangeQuantity = function ($val, $id){

    try {
        $this->form->changeQuantityRecieved($val, $id);
    } catch (\Throwable $th) {
        Log::debug($th->getMessage());
    }

};

$handleFinishDO = function (){
    try {
        $this->form->finishDO();
        $this->dispatch('finish-do');
    } catch (\Throwable $th) {
        $this->dispatch('finish-do-failed', $th->getMessage());
    }
};

?>

<x-layouts.app subheaderTitle="Detail Delivery Order" >
    @volt
    <div class="container">

        <div class="card-custom card">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Delivery Order
                        @if ($this->form->deliveryOrder->status == 'Selesai')
                        <span class="ml-3 label label-pill label-xl label-inline label-rounded label-success">Selesai</span>
                        @endif
                    </h3>
                </div>
                <div class="card-toolbar">
                    @if ($form->deliveryOrder->status == 'Diterima')
                    <button wire:click="handleFinishDO" type="button" class="btn btn-sm btn-outline-success font-weight-bold mr-4">
                        <i class="flaticon2-accept "></i> Selesai
                    </button>
                    @endif
                    <a href="#" class="btn btn-sm btn-info font-weight-bold">
                        <i class="flaticon2-print"></i> Cetak DO
                    </a>
                </div>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Counter :</label>
                            <input type="text" value="{{ $form->deliveryOrder->counter->name }} ({{ $form->deliveryOrder->counter->code }})" readonly class="form-control form-control-solid"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Nomor DO :</label>
                            <input type="text" value="{{ $form->deliveryOrder->do_number }}" readonly class="form-control form-control-solid"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Tanggal Order :</label>
                            <input type="date" readonly wire:model="form.order_date" class="form-control @error('form.order_date') is-invalid @enderror"/>
                            @error('form.order_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jam Order :</label>
                            <input type="time" readonly wire:model="form.order_time" class="form-control @error('form.order_time') is-invalid @enderror"/>
                            @error('form.order_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Tanggal Delivery :</label>
                            <input type="date" readonly wire:model="form.delivery_date" class="form-control @error('form.delivery_date') is-invalid @enderror"/>
                            @error('form.delivery_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jam Delivery :</label>
                            <input type="time" readonly wire:model="form.delivery_time" class="form-control @error('form.delivery_time') is-invalid @enderror"/>
                            @error('form.delivery_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>                        
                    </div>
                </div>
            </div>
        </div>

        <form class="form" wire:submit="submit" >
            <div class="card card-custom mt-8">
                <div class="card-body">
                    <table class="table text-center table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="vertical-align: middle;" rowspan="2" >#</th>
                                <th style="vertical-align: middle;" rowspan="2" >Barang</th>
                                <th style="vertical-align: middle;" rowspan="2" >Satuan</th>
                                <th class="text-center"  style="vertical-align: middle;" colspan="2" >Jumlah</th>
                                <th rowspan="2" style="vertical-align: middle;" >Status</th>
                            </tr>
                            <tr>
                                <th class="text-center" >Diminta</th>
                                <th class="text-center" >Diterima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($form->deliveryOrder->items as $i => $item)
                                <tr>
                                    <td style="vertical-align: middle;" >{{ $i+1 }}</td>
                                    <td style="vertical-align: middle;" >{{ $item->item->name }}</td>
                                    <td style="vertical-align: middle;" >{{ $item->item->unit }}</td>
                                    <td style="vertical-align: middle;" class="text-center" >{{ $item->quantity }}</td>
                                    <td class="text-center" >
                                        @if ($form->deliveryOrder->status != 'Selesai')
                                        <input min="0" wire:change="handleChangeQuantity($event.target.value, {{ $item->id }})" style="width: 100px;" value="{{ $item->quantity_recieved }}" type="number" class="form-control mx-auto" >
                                        @else
                                        {{ $item->quantity_recieved }}
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;" >
                                        @if ($item->status)
                                        <span class="label label-lg font-weight-bold label-rounded label-success">
                                            <i class="flaticon2-check-mark text-white icon-nm" ></i>
                                        </span>
                                        @else
                                        <span class="label label-lg font-weight-bold label-rounded label-danger">
                                            <i class="flaticon2-cross text-white icon-nm" ></i>
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="/operational/delivery-order" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>

    <script>


        document.addEventListener('livewire:navigated', () => { 

            @this.on('finish-do', () => {
                $.notify({
                    message: 'Delivery Order Selesai',
                },{
                    type: 'success',
                    placement: {
                        align: 'center'
                    },
                    animate: {
                        enter: 'animate__animated animate__slideInDown',
                        exit: 'animate__animated animate__slideOutUp'
                    }
                });
            })

            @this.on('finish-do-failed', (msg) => {
                $.notify({
                    message: 'Delivery Order gagal : ' + msg,
                },{
                    type: 'success',
                    placement: {
                        align: 'center'
                    },
                    animate: {
                        enter: 'animate__animated animate__slideInDown',
                        exit: 'animate__animated animate__slideOutUp'
                    }
                });
            })

        })

    </script>

    @endvolt
</x-layouts.app>
