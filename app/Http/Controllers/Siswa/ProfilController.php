<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        $siswa->load('kelas.jurusan');
        return view('siswa.profil.index', compact('user', 'siswa'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($siswa) {
            $siswa->telepon = $request->telepon;
            $siswa->alamat = $request->alamat;

            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $siswa->foto = $request->file('foto')->store('foto-siswa', 'public');
            }

            $siswa->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
