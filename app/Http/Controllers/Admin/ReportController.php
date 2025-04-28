<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Registration;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = Payment::orderBy('updated_at', 'desc')->get();
        $dataJurusan = Major::all();
        $dataPembayaran = PaymentType::all();
        $dataGelombang =  Registration::select('name')->distinct()->get();
        $dataAngkatan =  Registration::select('year')->distinct()->get();
        return view('admin.report.index', compact('data', 'dataJurusan', 'dataPembayaran', 'dataGelombang', 'dataAngkatan'));
    }

    public function showInvoice($transaction_id)
    {
        $payment = Payment::where('transaction_id', $transaction_id)->firstOrFail();
        return view('invoice.download', compact('payment'));
    }
}
