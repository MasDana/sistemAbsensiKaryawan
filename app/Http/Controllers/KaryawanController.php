<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->select('karyawan.*', 'jabatan.nama_jabatan') // Pastikan 'nama_jabatan' adalah nama kolom yang benar di tabel 'jabatan'
            ->orderBy('karyawan.nama_karyawan')
            ->paginate(1);
        return view('admin.rekapkaryawan', compact('karyawan'));
    }
}
