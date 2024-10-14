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
        return view('absensi.create');
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
        $data = [
            'karyawan_id' => $karyawan_id,
            'tanggal_presensi' => $tanggal_presensi,
            'jam_masuk' => $jam,
            'foto_masuk' => $fileName,
            'lokasi_in' => $lokasi
        ];
        $simpan = DB::table('presensi')->insert($data);
        if ($simpan) {
            echo 0;
            // Storage::put($file, $image_base64);
            Storage::disk('public')->put($folderPath . "/" . $fileName, $image_base64);
        } else {
            echo 1;
        }
    }
}
