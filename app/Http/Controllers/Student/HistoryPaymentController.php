<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryPaymentController extends Controller
{
    public function index()
    {
        return view('mahasiswa.history_payment.index');
    }
}
