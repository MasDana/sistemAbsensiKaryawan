<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\CekLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/sesi', function () {
//     $user = Auth::guard('karyawan')->user();
//     return view('sesi/index')->name('login');
// });

Route::get('/sesi', function () {
    // Check if the user is already logged in
    if (Auth::guard('karyawan')->check()) {
        // Redirect the logged-in user to a different page (e.g., dashboard)
        return redirect('dashkar'); // Adjust this route as needed
    }

    // If not logged in, show the login page
    return view('sesi.index');
})->name('login');

Route::middleware(['guest:karyawan'])->group(function () {
    Route::post('/sesi/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'register']);
    Route::post('/sesi/create', [RegisterController::class, 'create']);
});



Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashkar', [AbsensiController::class, 'dashboard']);
    Route::get('/sesi/logout', [LoginController::class, 'logout']);
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::post('/absensi/store', [AbsensiController::class, 'store']);
    Route::get('/presensi/histori', [AbsensiController::class, 'histori']);
    Route::post('/gethistori', [AbsensiController::class, 'gethistori']);
    Route::get('/editprofile', [AbsensiController::class, 'editprofile']);
    Route::post('/presensi/{id}/updateprofile', [AbsensiController::class, 'updateprofile']);

    Route::get('/presensi/izin', [AbsensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [AbsensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [AbsensiController::class, 'storeizin']);

    Route::get('/izin', [IzinController::class, 'createizin']);
    Route::post('/izin/store', [IzinController::class, 'storeizin']);
    Route::get('/izin/edit/{id}', [IzinController::class, 'editizin'])->name('izin.edit');
    Route::delete('/izin/delete/{id}', [IzinController::class, 'deleteizin'])->name('izin.delete');
    Route::post('izin/{kode_izin}/update', [IzinController::class, 'updateizin']);

    Route::get('/sakit', [IzinController::class, 'createsakit']);
    Route::post('/sakit/store', [IzinController::class, 'storesakit']);
    Route::get('/sakit/edit/{kode_izin}', [IzinController::class, 'editsakit'])->name('sakit.edit');
    Route::delete('/sakit/delete/{id}', [IzinController::class, 'deletesakit'])->name('sakit.delete');
    Route::post('sakit/{kode_izin}/update', [IzinController::class, 'updatesakit']);

    Route::get('/karyawan/{id}/edit', [AbsensiController::class, 'editprofile']);
    Route::post('/karyawan/{id}', [AbsensiController::class, 'updateprofile']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', [LoginController::class, 'adminindex']);
    Route::post('/sesi/loginadmin', [LoginController::class, 'loginadmin']);
});


Route::middleware(['auth:user'])->group(function () {
    Route::get('/dashboard', [AbsensiController::class, 'dashboardadmin']);
    Route::get('/sesi/logoutadmin', [LoginController::class, 'logoutadmin']);
    Route::get('/presensi/monitoring', [AbsensiController::class, 'monitoring']);
    Route::post('/getpresensi', [AbsensiController::class, 'getpresensi']);
    Route::get('/rekapkaryawan', [KaryawanController::class, 'index']);

    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelok', [KonfigurasiController::class, 'updatelokasi']);

    Route::post('/store/karyawan-data', [KaryawanController::class, 'simpan']);
    Route::get('/rekapjabatan', [KaryawanController::class, 'rekapjabatan']);
    Route::post('/store/jabatan-data', [KaryawanController::class, 'simpanjabatan']);
    Route::get('/jabatan/edit/{id}', [KaryawanController::class, 'edit'])->name('jabatan.edit');
    Route::put('/update/jabatan-data/{id}', [KaryawanController::class, 'updatejabatan'])->name('jabatan.update');

    Route::get('/presensi/izinsakit', [AbsensiController::class, 'izinsakit']);
    Route::post('/presensi/approveizinsakit', [AbsensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{kode_izin}/batalkanizinsakit', [AbsensiController::class, 'batalkanizinsakit']);


    Route::get('/karyawan/{id}/edit', [AbsensiController::class, 'edit']);
    Route::put('/update/karyawan-data', [AbsensiController::class, 'update']);
    Route::delete('/karyawan/{id}', [AbsensiController::class, 'destroy']);

    Route::put('/update/jabatan/{id}', [AbsensiController::class, 'updateJabatan']);
    Route::delete('/jabatan/{id}', [AbsensiController::class, 'hapusJabatan'])->name('jabatan.hapus');

    Route::post('/presensi/cekpengajuanizin', [AbsensiController::class, 'cekpengajuan']);

    Route::get('/rekappribadi', [RekapController::class, 'rekappribadi']);
    Route::post('/presensi/laporanpribadi', [RekapController::class, 'laporanpribadi']);

    Route::get('/rekapsemua', [RekapController::class, 'rekapsemua']);
    Route::post('/presensi/laporansemua', [RekapController::class, 'laporansemua']);
});


// Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
// Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
// Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');

// Route::get('/employeeDashboard', [EmployeeDashboardController::class, 'index']);
// Route::get('/sesi', [SessionController::class, 'index']);
// Route::post('/sesi/login', [SessionController::class, 'login']);

// Route::middleware('ceklevel')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });

// Route::get('/register', [SessionController::class, 'register']);
// Route::post('/sesi/create', [SessionController::class, 'create']);

// Route::resource('schedule', ScheduleController::class);

// Route::get('/employeeDashboard', [DashboardController::class, 'employee']);
