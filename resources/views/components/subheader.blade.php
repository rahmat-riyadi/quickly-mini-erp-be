@props(['subheaderTitle'])

<?php

use function Livewire\Volt\{state, mount, on}; 
use Illuminate\Support\Facades\Auth;
$logout = function (){
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
}

?>

<div wire:ignore class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h2 class="subheader-title text-dark font-weight-bold my-1 mr-3">{{ $subheaderTitle }}</h2>
                <!--end::Page Title-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center" data-offset="0,10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-column text-right">
                        @role('counter')
                        <span class="text-muted font-weight-bold">{{ auth()->user()->counter->name ?? '' }}</span>
                        <span class="font-weight-bold">{{ auth()->user()->username ?? '' }}</span>
                        @endrole
                        @unlessrole('counter')
                        <span class="text-muted font-weight-bold">{{ auth()->user()->employee->name ?? '' }}</span>
                        <span class="font-weight-bold">{{ auth()->user()->username ?? '' }}</span>
                        @endunlessrole
                    </div>
                    <div class="symbol symbol-40 symbol-primary ml-3">
                        @role('counter')
                        <span class="symbol-label font-size-h3">{{ auth()->user()->counter->name[0] ?? '' }}</span>
                        @endrole
                        @unlessrole('counter')
                        <span class="symbol-label font-size-h3">{{ auth()->user()->employee->name[0] ?? '' }}</span>
                        @endunlessrole
                    </div>
                </a>
                {{-- <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                    ...
                </div> --}}
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                    <a class="dropdown-item" wire:navigate href="/master-data/admin/{{ auth()->user()->id ?? '' }}">ubah profil</a>
                    @volt
                    <a wire:click="logout" class="dropdown-item text-danger" href="#">Logout</a>
                    @endvolt
                </div>
            </div>
        </div>
        <!--end::Toolbar-->
    </div>
</div>