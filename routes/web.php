<?php

use App\Http\Controllers\Admin\GelombangController;
use App\Http\Controllers\Admin\Mahasiswa;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['as' => 'admin.'], function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Route::get('/jurusans/dt', [JurusanController::class, 'dtJurusan'])->name('jurusans.dt');
    // Route::get('/jurusans/export/', [JurusanController::class, 'export'])->name('jurusans.export');
    // Route::post('jurusans/import', [JurusanController::class, 'import'])->name('jurusans.import');
    Route::resources([
        'jurusan' => MajorController::class,
        'gelombang' => RegistrationController::class,
    ]);
});
