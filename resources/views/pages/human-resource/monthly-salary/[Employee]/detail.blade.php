<?php

use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{state, mount}; 
use App\Models\Employee;

middleware(['auth']);
name('human-resource.monthly-salary.all');
state(['employee', 'base_salary', 'total_revenue']);

?>

<x-layouts.app subheaderTitle="sdf" >
    @volt
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center" ><u>Slip Gaji Karyawan</u></h4>
                <p class="text-center" >Periode Jul 2023</p>
                <div class="px-8">
                    <table>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>NIK</b></td>
                            <td>: 60200120116</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Nama</b></td>
                            <td>: Rahmat Riyadi</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Jabatan</b></td>
                            <td>: Web Developer</td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px;" ><b>Status</b></td>
                            <td>: Karyawan Tetap</td>
                        </tr>
                    </table>
                    <table style="margin-top: 40px; width: 100%;" >
                        <thead>
                            <tr>
                                <td colspan="2" style="font-weight: 600; font-size: 16px;" >Penghasilan</td>
                                <td colspan="2" style="font-weight: 600; font-size: 16px;" >Potongan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light" style="height: 30px;" >
                                <td>Gaji Pokok</td>
                                <td style="text-align: end; padding-right: 10px;" >213123</td>
                                <td>Denda Terlambat</td>
                                <td>213123</td>
                            </tr>
                            <tr style="height: 30px;" >
                                <td>Tunj Pokok</td>
                                <td style="text-align: end; padding-right: 10px;" >213123</td>
                                <td>Denda Terlambat</td>
                                <td>213123</td>
                            </tr>
                        </tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>