<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('mahasiswa.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|numeric',
            'birthdate' => 'required|date',
            'address' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $user->nim . '_' . str_replace(' ', '_', $user->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('mahasiswa', $imageName, 'public');
                $imagePath = 'mahasiswa/' . $imageName;
            } else {
                $imagePath = $student->image;
            }

            User::find($user->id)->update([
                'email' => $request->email
            ]);

            Student::where('user_id', $user->id)->update([
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'image' => $imagePath
            ]);
            DB::commit();

            return redirect()->route('mahasiswa.myprofile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('mahasiswa.myprofile')->with('error', $th->getMessage());
        }
    }
}
