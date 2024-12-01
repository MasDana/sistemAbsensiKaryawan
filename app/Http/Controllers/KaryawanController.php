<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('user')->user();
        $jabatan = Jabatan::all();
        $query = Karyawan::query();

        // Join tabel jabatan dan memilih kolom yang diperlukan
        $query->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->select('karyawan.*', 'jabatan.nama_jabatan')
            ->orderBy('karyawan.nama_karyawan');

        // Menambahkan filter pencarian jika nama_karyawan ada di request
        if ($request->nama_karyawan) {
            $query->where('nama_karyawan', 'like', '%' . $request->nama_karyawan . '%');
        }

        // Mendapatkan hasil query dengan paginasi
        $karyawan = $query->paginate(10);

        // Mengirimkan data ke view
        return view('admin.rekapkaryawan', compact('karyawan', 'jabatan', 'user'));
    }

    public function simpan(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_karyawans' => 'required',
            'jabatan_id' => 'required',
            'email' => 'required|email|unique:karyawan,email',
            'no_hp' => 'required',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:male,female', // Ubah validasi sesuai nilai enum
            'alamat' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'nama_karyawan' => $request->nama_karyawans,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'gender' => $request->gender, // Value dari form sudah 'male' atau 'female'
            'jabatan_id' => $request->jabatan_id,
            'password' => Hash::make($request->password)
        ];

        // Simpan data karyawan ke dalam database
        Karyawan::create($data);
    }

    public function rekapjabatan(Request $request)
    {
        $user = Auth::guard('user')->user();
        $jabatan = Jabatan::all();
        $query = Jabatan::query();

        // Menambahkan filter pencarian jika nama_karyawan ada di request
        if ($request->nama_jabatan) {
            $query->where('nama_jabatan', 'like', '%' . $request->nama_jabatan . '%');
        }

        // Mendapatkan hasil query dengan paginasi
        $jabatan = $query->paginate(10);

        // Mengirimkan data ke view
        return view('admin.rekapjabatan', compact('jabatan'));
    }

    public function simpanjabatan(Request $request)
    {
        $request->validate([
            'nama_jabatans' => 'required',
        ]);

        $data = [
            'nama_jabatan' => $request->nama_jabatans,
        ];

        // Simpan data karyawan ke dalam database
        Jabatan::create($data);
    }

    public function update(Request $request, $id)
    {
        $id = Auth::guard('jabatan')->user()->id;
        $karyawan = DB::table('jabatan')->where('id', $id)->first();

        return view('admin.rekapjabatan', compact('jabatan'));
    }
}
