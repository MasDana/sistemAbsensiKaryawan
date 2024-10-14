<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{

    function index()
    {
        return view("sesi/register");
    }

    function register()
    {
        $jabatan = Jabatan::all(); // Mengambil semua posisi dari database
        return view('sesi/register', compact('jabatan')); // Mengirimkan variabel $positions dan $schedules ke view

    }

    function create(Request $request)
    {
        // Simpan data untuk flash session
        Session::flash('email', $request->email);
        Session::flash('nama_karyawan', $request->name);

        // Validasi request
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:15', // Anggap bahwa nomor telepon bisa kosong dan maksimal 15 karakter
            'tanggal_lahir' => 'nullable|date|before:today', // Validasi tanggal lahir agar tidak lebih dari hari ini
            'alamat' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female', // Misalnya jika gender harus salah satu dari nilai ini
            'jabatan_id' => 'required|exists:jabatan,id', // Validasi bahwa posisi harus ada di tabel positions
            'password' => 'required|string|min:3|confirmed', // Validasi password
        ], [
            'nama_karyawan.required' => 'Nama wajib diisi',
            'nama_karyawan.string' => 'Nama harus berupa teks',
            'nama_karyawan.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Silahkan masukkan email yang valid',
            'email.unique' => 'Email sudah digunakan',
            'no_hp.string' => 'Nomor telepon harus berupa teks',
            'no_hp.max' => 'Nomor telepon maksimal 15 karakter',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'alamat.string' => 'Alamat harus berupa teks',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'gender.in' => 'Jenis kelamin harus salah satu dari male atau female',
            'jabatan_id.required' => 'Posisi wajib dipilih',
            'jabatan_id.exists' => 'Posisi tidak ditemukan',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 3 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Data untuk disimpan ke database
        $data = [
            'nama_karyawan' => $request->nama_karyawan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'jabatan_id' => $request->jabatan_id,
            'password' => Hash::make($request->password)
        ];

        // Simpan data karyawan ke dalam database
        Karyawan::create($data);

        // Redirect ke halaman sesi
        return redirect('sesi');
    }
}
