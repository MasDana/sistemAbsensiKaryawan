<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Menampilkan halaman login
    function index()
    {
        return view("sesi/index");
    }

    // Fungsi untuk login
    function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 3 karakter',
        ]);

        // Info login yang dimasukkan
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Cek login menggunakan guard 'karyawan'
        if (Auth::guard('karyawan')->attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard
            return redirect('/dashkar');
        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error
            return redirect('sesi')->withErrors(['default' => 'Email atau password yang Anda masukkan salah']);
        }
    }

    // Fungsi untuk logout
    function logout()
    {
        Auth::guard('karyawan')->logout();
        Session::flush(); // Hapus semua session

        // Redirect ke halaman login setelah logout
        return redirect('sesi');
    }

    function loginadmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 3 karakter',
        ]);

        // Info login yang dimasukkan
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Cek login menggunakan guard 'karyawan'
        if (Auth::guard('user')->attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard
            return redirect('/dashboard');
        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error
            return redirect('admin.login')->withErrors(['default' => 'Email atau password yang Anda masukkan salah']);
        }
    }
}
