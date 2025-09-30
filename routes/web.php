<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\HomeController;

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
    return view('Anda mengakses marakuliah');
});

Route::get('/blade', [PegawaiController::class, 'index']);

Route::get('/home', [HomeController::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');
