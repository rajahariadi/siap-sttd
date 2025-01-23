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
    Route::get('/gelombangs/export/', [GelombangController::class, 'export'])->name('gelombangs.export');
    Route::post('gelombangs/import', [GelombangController::class, 'import'])->name('gelombangs.import');

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
