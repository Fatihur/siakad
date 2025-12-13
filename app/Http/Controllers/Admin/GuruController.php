<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Guru, User, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::with('user')->latest()->get();
        return view('admin.guru.index', compact('data'));
    }

    public function create()
    {
        return view('admin.guru.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:30|unique:guru,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'username' => $request->nip,
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);

        $data = $request->only(['nip', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru = Guru::create($data);
        AuditLog::catat('guru', $guru->id, 'create', null, $guru->toArray());

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan. Password default: password123');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.form', ['data' => $guru]);
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|string|max:30|unique:guru,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $old = $guru->toArray();
        $guru->user->update(['name' => $request->nama, 'email' => $request->email, 'username' => $request->nip]);

        $data = $request->only(['nip', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon']);

        if ($request->hasFile('foto')) {
            if ($guru->foto) Storage::disk('public')->delete($guru->foto);
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);
        AuditLog::catat('guru', $guru->id, 'update', $old, $guru->toArray());

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diupdate');
    }

    public function destroy(Guru $guru)
    {
        AuditLog::catat('guru', $guru->id, 'delete', $guru->toArray(), null);
        if ($guru->foto) Storage::disk('public')->delete($guru->foto);
        $guru->user->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }
}
