<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = Payment::orderBy('updated_at', 'desc')->get();
        return view('admin.report.index', compact('data'));
    }

    public function showInvoice($transaction_id)
    {
        $payment = Payment::where('transaction_id', $transaction_id)->firstOrFail();
        return view('invoice.download', compact('payment'));
    }
}
