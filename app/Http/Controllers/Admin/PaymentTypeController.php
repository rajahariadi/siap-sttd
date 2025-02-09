<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PaymentType::all();
        return view('admin.payment_type.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'description' => 'required'
        ]);

        try {
            PaymentType::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
            return redirect()->route('admin.jenis-pembayaran.index')->with('success', "Jenis Pembayaran berhasil ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jenis-pembayaran.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = PaymentType::find($id);
        return view('admin.payment_type.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'description' => 'required'
        ]);

        try {
            PaymentType::find($id)->update([
                'name' => $request->name,
                'description' => $request->description
            ]);
            return redirect()->route('admin.jenis-pembayaran.index')->with('success', "Jenis Pembayaran berhasil diperbaruhi");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jenis-pembayaran.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            PaymentType::find($id)->delete();
            return redirect()->route('admin.jenis-pembayaran.index')->with('success', "Jenis Pembayaran berhasil dihapus");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jenis-pembayaran.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
