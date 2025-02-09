<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Registration::all();
        return view('admin.registration.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.registration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:8',
            'year' => 'required|integer'
        ]);

        try {
            Registration::create([
                'name' => $request->name,
                'year' => $request->year
            ]);
            return redirect()->route('admin.gelombang.index')->with('success', "Gelombang berhasil ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->route('admin.gelombang.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
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
        $data = Registration::find($id);
        return view('admin.registration.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:8',
            'year' => 'required|integer'
        ]);

        try {
            Registration::find($id)->update([
                'name' => $request->name,
                'year' => $request->year
            ]);
            return redirect()->route('admin.gelombang.index')->with('success', "Gelombang berhasil diperbaruhi");
        } catch (\Throwable $th) {
            return redirect()->route('admin.gelombang.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Registration::find($id)->delete();
            return redirect()->route('admin.gelombang.index')->with('success', "Gelombang berhasil dihapus");
        } catch (\Throwable $th) {
            return redirect()->route('admin.gelombang.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
