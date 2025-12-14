<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $guru = $user->guru;
        return view('guru.profil.index', compact('user', 'guru'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $guru = $user->guru;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($guru) {
            $guru->nama = $request->nama;
            $guru->telepon = $request->telepon;
            $guru->alamat = $request->alamat;

            if ($request->hasFile('foto')) {
                if ($guru->foto) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $guru->foto = $request->file('foto')->store('foto-guru', 'public');
            }

            $guru->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
