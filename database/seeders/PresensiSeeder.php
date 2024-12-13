<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $karyawanIds = [102, 111, 112, 113, 114, 115]; // ID karyawan
        $tanggalMulai = '2024-12-01';
        $tanggalAkhir = '2024-12-12';
        $jamMasuk = '08:00:00';
        $jamKeluar = '18:00:00';
        $fotoMasuk = 'testabsen.jpg';
        $fotoKeluar = 'testabsen.jpg';
        $lokasi = '-8.796081314356927, 115.17671449131369';
        $status = 'h';

        foreach ($karyawanIds as $karyawanId) {
            $tanggal = $tanggalMulai;
            while (strtotime($tanggal) <= strtotime($tanggalAkhir)) {
                DB::table('presensi')->insert([
                    'karyawan_id' => $karyawanId,
                    'tanggal_presensi' => $tanggal,
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'foto_masuk' => $fotoMasuk,
                    'foto_keluar' => $fotoKeluar,
                    'lokasi_in' => $lokasi,
                    'lokasi_out' => $lokasi,
                    'status' => $status,
                    'kode_izin' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Tambahkan 1 hari ke tanggal
                $tanggal = date('Y-m-d', strtotime($tanggal . ' +1 day'));
            }
        }
    }
}
