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

    public function adminindex()
    {
        // Pastikan pengguna tidak terautentikasi sebelum menampilkan halaman login
        if (auth()->guard('user')->check()) {
            return redirect()->route('/dashboard');  // Jika sudah login, arahkan ke dashboard admin
        }

        return view('admin.login');  // Jika belum login, tampilkan halaman login
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

    function logoutadmin()
    {
        Auth::guard('user')->logout();
        Session::flush(); // Hapus semua session

        // Redirect ke halaman login setelah logout
        return redirect('dashboard');
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
            return redirect('/panel')->withErrors(['default' => 'Email atau password yang Anda masukkan salah']);
        }
    }
}
