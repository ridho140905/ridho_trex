<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR saya!';
});
Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: '.$param1;
});
Route::get('/mahasiswa/{param1?}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/Matakuliah', function () {
    return view('Anda mengakses matakuliah');
});

Route::get('/blade', [PegawaiController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
//Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

//Route::get('/auth/register', function () {
   // return view('form-register');
//})->name('auth.showRegister');

//Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::resource('pelanggan', PelangganController::class);
