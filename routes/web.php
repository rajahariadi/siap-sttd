<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.index');
    });
});

// Route::group(['as' => 'mahasiswa.'], function () {
//     Route::get('/dashboard', function () {
//         echo 'mahasiswa';
//     });
// });
