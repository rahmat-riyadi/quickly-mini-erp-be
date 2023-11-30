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
                    <div class="card-toolbar">
                        <ul class="nav nav-light-primary nav-bold nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#general">
                                    <span class="nav-icon"><i class="flaticon2-paper"></i></span>
                                    <span class="nav-text">Data Umum</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#employment">
                                    <span class="nav-icon"><i class="flaticon2-calendar-3"></i></span>
                                    <span class="nav-text">Kepegawaian</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#account">
                                    <span class="nav-icon"><i class="flaticon2-protected"></i></span>
                                    <span class="nav-text">Akun</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="general" >
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Nama :</label>
                                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror" placeholder="Masukan Nama"/>
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
                                                <input type="text" wire:model="form.nik" class="form-control @error('form.nik') is-invalid @enderror" placeholder="Masukan NIK"/>
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
                                                <input type="text" wire:model="form.kk" class="form-control @error('form.kk') is-invalid @enderror" placeholder="Masukan No. KK"/>
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
                                                <input type="text" wire:model="form.place_of_birth" class="form-control @error('form.place_of_birth') is-invalid @enderror" placeholder="Masukan Tempat Lahir"/>
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
                                                <input type="text" wire:model="form.date_of_birth" class="form-control @error('form.date_of_birth') is-invalid @enderror" placeholder="Masukan Tanggal Lahir"/>
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
                                        <input type="text" wire:model="form.address" class="form-control @error('form.address') is-invalid @enderror" placeholder="Masukan Alamat"/>
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
                                                <input type="text" wire:model="form.city" class="form-control @error('form.city') is-invalid @enderror" placeholder="Masukan Jabatan"/>
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
                                                <input type="text" wire:model="form.province" class="form-control @error('form.province') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                                @error('form.province')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Telepon :</label>
                                        <input type="text" wire:model="form.phone" class="form-control @error('form.phone') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                        @error('form.phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input type="text" wire:model="form.email" class="form-control @error('form.email') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                        @error('form.email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Waktu Masuk :</label>
                                                <input type="text" wire:model="form.entry_date" class="form-control @error('form.entry_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
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
                                                <input type="text" wire:model="form.exit_date" class="form-control @error('form.exit_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                                @error('form.exit_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex">
                                        <div class="mx-auto" >
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                @if (empty($this->form->image))
                                                <div class="image-input-wrapper" style="background-image: url(assets/media/users/100_1.jpg)"></div>
                                                @else
                                                <div class="image-input-wrapper" style="background-image: url({{ $this->form->image->temporaryUrl() }})"></div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="employment" >
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Waktu Masuk :</label>
                                        <input type="date" wire:model="form.entry_date" class="form-control @error('form.entry_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
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
                                        <input type="date" wire:model="form.exit_date" class="form-control @error('form.exit_date') is-invalid @enderror" placeholder="Masukan Jabatan"/>
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
                                        <select wire:model="form.position_id" name="position_id" class="custom-select form-control">
                                            <option value="">pilih jabatan</option>
                                            @foreach ($positions as $item)
                                            <option value="{{ $item->id }}"  >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Status :</label>
                                        <select name="status" wire:model="form.status" class="custom-select form-control">
                                            <option value="">pilih status</option>
                                            <option value="1"  >Aktif</option>
                                            <option value="0" >Non Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account" >
                            <div class="form-group">
                                <label>Nama Pengguna :</label>
                                <input type="text" wire:model="form.username" class="form-control @error('form.username') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                @error('form.username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kata Sandi :</label>
                                <input type="text" wire:model="form.newPass" class="form-control @error('form.newPass') is-invalid @enderror" placeholder="Masukan Jabatan"/>
                                @error('form.newPass')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">
                        <span wire:loading >loading</span>
                        <span wire:loading.remove >Simpan</span>
                    </button>
                    <a href="/human-resource/employee" wire:navigate class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    @endvolt
</x-layouts.app>
