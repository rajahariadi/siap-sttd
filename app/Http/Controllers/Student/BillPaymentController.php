<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillPaymentController extends Controller
{
    public function index()
    {

        return view('mahasiswa.bill_payment.index');
    }
}
