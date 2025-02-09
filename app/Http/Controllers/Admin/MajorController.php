<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Major::all();
        return view('admin.major.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.major.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:majors,code',
            'name' => 'required|string|min:8',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('jurusan', $imageName, 'public');
                $imagePath = 'jurusan/' . $imageName;
            } else {
                return redirect()->back()->with('error', 'No image file uploaded.');
            }

            Major::create([
                'code' => $request->code,
                'name' => $request->name,
                'image' => $imagePath,
            ]);
            return redirect()->route('admin.jurusan.index')->with('success', "Jurusan berhasil ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jurusan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
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
        $data = Major::find($id);
        return view('admin.major.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $major = Major::find($id);
        $request->validate([
            'code' => 'required|string|unique:majors,code,' . $id,
            'name' => 'required|string|min:8',
        ]);

        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('jurusan', $imageName, 'public');
                $imagePath = 'jurusan/' . $imageName;
            } else {
                $imagePath = $major->image;
            }

            Major::find($id)->update([
                'code' => $request->code,
                'name' => $request->name,
                'image' => $imagePath,
            ]);
            return redirect()->route('admin.jurusan.index')->with('success', "Jurusan berhasil diperbaruhi");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jurusan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Major::find($id)->delete();
            return redirect()->route('admin.jurusan.index')->with('success', "Jurusan berhasil dihapus");
        } catch (\Throwable $th) {
            return redirect()->route('admin.jurusan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
