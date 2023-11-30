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
                                <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Insentif</td>
                                <td colspan="2" style="font-weight: 600; font-size: 16px; width: 50%;" >Lembur & Bonus</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light" style="height: 33px;" >
                                <td>Kehadiran</td>
                                <td style="text-align: end; padding-right: 10px;" >Rp 210,000</td>
                                <td>Lembur Biasa</td>
                                <td>213123</td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td>Transport</td>
                                <td style="text-align: end; padding-right: 10px;" >Rp 50,000</td>
                                <td>Lembur Tanggal Merah</td>
                                <td>213123</td>
                            </tr>
                            <tr class="bg-light" style="height: 33px;" >
                                <td>Split</td>
                                <td style="text-align: end; padding-right: 10px;" >Rp 150,000</td>
                                <td>Lembur Fix</td>
                                <td>213123</td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td></td>
                                <td style="text-align: end; padding-right: 10px;" ></td>
                                <td>Bonus</td>
                                <td>213123</td>
                            </tr>
                            <tr class="bg-light" style="height: 33px;" >
                                <td></td>
                                <td style="text-align: end; padding-right: 10px;" ></td>
                                <td>THR</td>
                                <td>213123</td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td><b>Total</b></td>
                                <td style="text-align: end; padding-right: 10px;" ><b>Rp 200,000</b></td>
                                <td><b>Total</b></td>
                                <td ><b>Rp 200,000</b></td>
                            </tr>
                            <tr style="height: 10px;" >
                                <td colspan="4" ></td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td colspan="2" style="font-weight: 600; font-size: 16px;" >Potongan</td>
                                <td colspan="2" ></td>
                            </tr>
                            <tr class="bg-light" style="height: 33px;" >
                                <td>Terlambat</td>
                                <td style="text-align: end; padding-right: 10px;" >213123</td>
                                <td colspan="2" ></td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td>Denda</td>
                                <td style="text-align: end; padding-right: 10px;" >213123</td>
                                <td colspan="2" ></td>
                            </tr>
                            <tr class="bg-light" style="height: 33px;" >
                                <td>Absen</td>
                                <td style="text-align: end; padding-right: 10px;" >213123</td>
                                <td colspan="2" ></td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td colspan="2" ></td>
                                <td ><b>Gaji</b> Pokok</td>
                                <td><b>2,000,000</b></td>
                            </tr>
                            <tr style="height: 33px;" >
                                <td colspan="2" ></td>
                                <td ><b>Gaji</b> Bersih</td>
                                <td><b>2,000,000</b></td>
                            </tr>
                        </tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                    <table style="margin-top: 120px; width: 100%;" >
                        <tr>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Personalia</p>
                            </td>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Penerima</p>
                            </td>
                            <td style="padding: 0 20px;" >
                                <div style="border-bottom: 1px solid black;" ></div>
                                <p class="m-0" >Pembukan</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>