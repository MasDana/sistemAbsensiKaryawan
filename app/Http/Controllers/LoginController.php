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
        return view('sesi.index');
    }

    public function adminindex()
    {
        // Pastikan pengguna tidak terautentikasi sebelum menampilkan halaman login
        if (auth()->guard('user')->check()) {
            return view('admin.dashboard');  // Jika sudah login, arahkan ke dashboard admin
        }

        return view('admin.login');  // Jika belum login, tampilkan halaman login
    }


    // Fungsi untuk login
    // function login(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:3',
    //     ], [
    //         'email.required' => 'Email wajib diisi',
    //         'email.email' => 'Format email tidak valid',
    //         'password.required' => 'Password wajib diisi',
    //         'password.min' => 'Password minimal 3 karakter',
    //     ]);

    //     // Info login yang dimasukkan
    //     $credentials = [
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];

    //     // Cek login menggunakan guard 'karyawan'
    //     if (Auth::guard('karyawan')->attempt($credentials)) {
    //         // Jika login berhasil, redirect ke dashboard
    //         return redirect('/dashkar');
    //     } else {
    //         // Jika gagal, kembali ke halaman login dengan pesan error
    //         return redirect('sesi')->withErrors(['default' => 'Email atau password yang Anda masukkan salah']);
    //     }
    // }


    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password harus lebih dari 3 karakter',
        ]);

        // Attempt to authenticate the user
        if (Auth::guard('karyawan')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // If authentication is successful, redirect to the intended page or dashboard
            return redirect()->intended('/dashboard');  // Redirects to /dashboard if no prior URL, else to the one they tried to access
        } else {
            // If authentication fails, redirect back with an error message
            return back()->withErrors([
                'email' => 'Kredensial Anda tidak valid',
            ]);
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
        return redirect('panel');
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
