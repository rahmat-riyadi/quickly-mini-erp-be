<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\EmployeeForm;
use App\Models\Employee;
use App\Models\Position;

middleware(['auth']);
name('human-resource.employee.edit');
form(EmployeeForm::class);

state(['positions']);

mount(function(Employee $employee){
    $this->form->setModel($employee);
    $this->positions = Position::all();
});

$submit = function (){
    try {
        $this->form->update();
        session()->flash('success', 'Data berhasil diubah');
        $this->redirect('/human-resource/employee');
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('/human-resource/employee');
    }
};

?>

<x-layouts.app subheaderTitle="Edit Data" >
    @volt
    <div class="container">
        <form class="form" wire:submit="submit" >
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title" >
                        Tambah Pegawai
                    </div>
                </div>
                <div class="card-body">

                    <h6 class="text-primary" >Data Umum</h4>
                    <div class="separator separator-dashed my-5"></div>

                    <div class="mb-8" >
                        <div class="image-input image-input-outline" id="kt_image_1">
                            @if (empty($form->image))
                            <div class="image-input-wrapper" style="background-image: url(assets/media/users/100_1.jpg)"></div>
                            @else
                            <div class="image-input-wrapper" style="background-image: url({{ asset('storage/'.$form->image) }})"></div>
                            @endif
                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input wire:model="form.image" type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="profile_avatar_remove" />
                            </label>
                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nama :</label>
                        <input type="text" wire:model="form.name" class="form-control form-control-solid @error('form.name') is-invalid @enderror" placeholder="Masukan Nama"/>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>NIK :</label>
                                <input type="text" wire:model="form.nik" class="form-control form-control-solid @error('form.nik') is-invalid @enderror" placeholder="Masukan NIK"/>
                                @error('form.nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>No. KK :</label>
                                <input type="text" wire:model="form.kk" class="form-control form-control-solid @error('form.kk') is-invalid @enderror" placeholder="Masukan No. KK"/>
                                @error('form.kk')
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
                                <label>Tempat Lahir :</label>
                                <input type="text" wire:model="form.place_of_birth" class="form-control form-control-solid @error('form.place_of_birth') is-invalid @enderror" placeholder="Masukan Tempat Lahir"/>
                                @error('form.place_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Tanggal Lahir :</label>
                                <input type="date" wire:model="form.date_of_birth" class="form-control form-control-solid @error('form.date_of_birth') is-invalid @enderror" placeholder="Masukan Tanggal Lahir"/>
                                @error('form.date_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat :</label>
                        <input type="text" wire:model="form.address" class="form-control form-control-solid @error('form.address') is-invalid @enderror" placeholder="Masukan Alamat"/>
                        @error('form.address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Kota :</label>
                                <input type="text" wire:model="form.city" class="form-control form-control-solid @error('form.city') is-invalid @enderror" placeholder="Masukan Kota"/>
                                @error('form.city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Provinsi :</label>
                                <input type="text" wire:model="form.province" class="form-control form-control-solid @error('form.province') is-invalid @enderror" placeholder="Masukan Provinsi"/>
                                @error('form.province')
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
                                <label>No. Telepon :</label>
                                <input type="number" wire:model="form.phone" class="form-control form-control-solid @error('form.phone') is-invalid @enderror" placeholder="Masukan No telepon"/>
                                @error('form.phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email :</label>
                                <input type="email" wire:model="form.email" class="form-control form-control-solid @error('form.email') is-invalid @enderror" placeholder="Masukan Email"/>
                                @error('form.email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary" >Kepegawaian</h4>
                    <div class="separator separator-dashed my-5"></div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Waktu Masuk :</label>
                                <input type="date" wire:model="form.entry_date" class="form-control form-control-solid @error('form.entry_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                @error('form.entry_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Waktu Keluar :</label>
                                <input type="date" wire:model="form.exit_date" class="form-control form-control-solid @error('form.exit_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                @error('form.exit_date')
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
                                <label>Posisi :</label>
                                <select wire:model="form.position_id" class="custom-select form-control form-control-solid @error('form.position_id') is-invalid @enderror">
                                    <option >-- Pilih --</option>
                                    @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                                @error('form.position_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Status :</label>
                                <select wire:model="form.status" class="custom-select form-control form-control-solid">
                                    <option >-- Pilih --</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary" >Akun</h4>
                    <div class="separator separator-dashed my-5"></div>

                    <div class="form-group">
                        <label>Nama Pengguna :</label>
                        <input type="text" wire:model="form.username" class="form-control form-control-solid @error('form.name') is-invalid @enderror" placeholder="Masukan Username"/>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi :</label>
                        <input type="text" wire:model="form.password" class="form-control form-control-solid @error('form.name') is-invalid @enderror" placeholder="Masukan Password"/>
                        @error('form.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <button wire:loading.attr="disabled" wire:target="submit" type="submit" class="btn btn-primary mr-2">
                        Simpan
                    </button>
                    <a href="/human-resource/employee" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
