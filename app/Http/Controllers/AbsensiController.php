<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $hariIni = date("Y-m-d");
        $karyawan_id = Auth::guard('karyawan')->user()->id;

        // Mengganti 'id' menjadi 'karyawan_id' pada query
        $cek = DB::table('presensi')
            ->where('tanggal_presensi', $hariIni)
            ->where('karyawan_id', $karyawan_id) // Menggunakan karyawan_id, bukan id
            ->count();

        return view('absensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $tanggal_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = "upload/absensi";
        $formatName = $karyawan_id . "-" . $tanggal_presensi . "-" . time(); // Menambahkan timestamp ke nama file
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . "/" . $fileName;

        // Cek apakah karyawan sudah presensi hari ini
        $cek = DB::table('presensi')
            ->where('tanggal_presensi', $tanggal_presensi)
            ->where('karyawan_id', $karyawan_id) // Menggunakan karyawan_id, bukan id
            ->count();

        if ($cek > 0) {
            // Jika sudah presensi masuk, lakukan update untuk absensi pulang
            $data_pulang = [
                'jam_keluar' => $jam,
                'foto_keluar' => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('presensi')
                ->where('tanggal_presensi', $tanggal_presensi)
                ->where('karyawan_id', $karyawan_id)
                ->update($data_pulang);

            if ($update) {
                echo 0;
                // Simpan foto ke storage
                Storage::disk('public')->put($folderPath . "/" . $fileName, $image_base64);
            } else {
                echo 1;
            }
        } else {
            // Jika belum presensi masuk, lakukan insert
            $data_masuk = [
                'karyawan_id' => $karyawan_id,
                'tanggal_presensi' => $tanggal_presensi,
                'jam_masuk' => $jam,
                'foto_masuk' => $fileName,
                'lokasi_in' => $lokasi
            ];
            $simpan = DB::table('presensi')->insert($data_masuk);
            if ($simpan) {
                echo 0;
                // Simpan foto ke storage
                Storage::disk('public')->put($folderPath . "/" . $fileName, $image_base64);
            } else {
                echo 1;
            }
        }
    }
}
