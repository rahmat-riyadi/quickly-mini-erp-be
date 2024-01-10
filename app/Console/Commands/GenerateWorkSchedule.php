<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateWorkSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        function buatJadwalKerja($jumlahKaryawan, $jamPerKaryawan, $jumlahHari, $hariLibur) {
            // Menghitung total jam kerja selama satu minggu
            $totalJamKerja = $jumlahKaryawan * $jamPerKaryawan * ($jumlahHari - $hariLibur);
        
            // Menghitung jam kerja per hari
            $jamPerHari = $totalJamKerja / ($jumlahHari - $hariLibur);
        
            // Membuat jadwal kerja
            $jadwalKerja = [];
        
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                if ($hari % ($jumlahHari + 1) != $hariLibur) {
                    $jadwalKerja[$hari] = $jamPerHari;
                } else {
                    $jadwalKerja[$hari] = 0; // Menetapkan 0 jam untuk hari libur
                }
            }
        
            // Mengembalikan jadwal kerja
            return $jadwalKerja;
        }
        
        // Jumlah karyawan
        $jumlahKaryawan = 10;
        
        // Jam kerja per karyawan per 6 hari
        $jamPerKaryawan = 54;
        
        // Jumlah hari dalam seminggu
        $jumlahHari = 7;
        
        // Nomor hari untuk libur (misalnya, Sabtu atau Minggu)
        $hariLibur = 6; // Misalnya, 6 adalah Sabtu
        
        // Memanggil fungsi buatJadwalKerja untuk mendapatkan jadwal kerja
        $jadwalKerja = buatJadwalKerja($jumlahKaryawan, $jamPerKaryawan, $jumlahHari, $hariLibur);
        
        // Menampilkan jadwal kerja
        foreach ($jadwalKerja as $hari => $jam) {
            // echo "Hari ke-$hari: $jam jam kerja <br>";
            $this->info($hari);
            $this->info($jam);
        }
    }
}
