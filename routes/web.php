<?php

use App\Http\Controllers\Admin\Gelombang;
use App\Http\Controllers\Admin\GelombangController;
use App\Http\Controllers\Admin\Jurusan;
use App\Http\Controllers\Admin\Mahasiswa;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('/gelombangs/dt', [GelombangController::class, 'dtGelombang'])->name('gelombangs.dt');


    Route::resources([
        'mahasiswas' => Mahasiswa::class,
        'jurusans' => Jurusan::class,
        'gelombangs' => GelombangController::class,
    ]);
});

// Route::group(['as' => 'mahasiswa.'], function () {
//     Route::get('/dashboard', function () {
//         echo 'mahasiswa';
//     });
// });
