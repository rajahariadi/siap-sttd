<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/dashboard');
        } elseif ($user->role === 'mahasiswa') {
            return redirect('/home');
        }

        return redirect('/login');
    });
});
