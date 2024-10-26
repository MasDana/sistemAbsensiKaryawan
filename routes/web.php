<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\CekLevel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sesi/index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
// Route::get('/employeeDashboard', [EmployeeDashboardController::class, 'index']);
// Route::get('/sesi', [SessionController::class, 'index']);
// Route::post('/sesi/login', [SessionController::class, 'login']);
Route::get('/sesi/logout', [LoginController::class, 'logout']);
// Route::get('/register', [SessionController::class, 'register']);
// Route::post('/sesi/create', [SessionController::class, 'create']);
Route::get('/employeeDashboard', [DashboardController::class, 'employee']);
// Route::resource('schedule', ScheduleController::class);



Route::get('/sesi', [LoginController::class, 'index']);
Route::post('/sesi/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'register']);
Route::post('/sesi/create', [RegisterController::class, 'create']);


// Route::middleware('ceklevel')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('ceklevel');

Route::get('/absensi', [AbsensiController::class, 'index']);
Route::post('/absensi/store', [AbsensiController::class, 'store']);

Route::get('/dashkar', [AbsensiController::class, 'dashboard']);

Route::get('/presensi/histori', [AbsensiController::class, 'histori']);
Route::post('/gethistori', [AbsensiController::class, 'gethistori']);

Route::middleware(['guest'])->group(function () {
    Route::get('/panel', function () {
        return view('admin.login');
    })->name('loginadmin');

    Route::post('/sesi/loginadmin', [LoginController::class, 'loginadmin']);
    Route::get('/editprofile', [AbsensiController::class, 'editprofile']);
    Route::post('/presensi/{id}/updateprofile', [AbsensiController::class], 'updateprofile');
});

Route::get('/presensi/monitoring', [AbsensiController::class, 'monitoring']);
Route::post('/getpresensi', [AbsensiController::class, 'getpresensi']);

Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');

// Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
// Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
// Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
