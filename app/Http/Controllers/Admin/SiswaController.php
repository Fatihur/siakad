<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, User, Kelas, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $data = Siswa::with(['user', 'kelas.jurusan'])->latest()->get();
        return view('admin.siswa.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        return view('admin.siswa.form', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nisn' => 'nullable|string|max:20|unique:siswa,nisn',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string',
            'telepon_wali' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'username' => $request->nis,
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $data = $request->only(['nis', 'nisn', 'nama', 'jenis_kelamin', 'kelas_id', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon', 'nama_wali', 'telepon_wali']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($data);
        AuditLog::catat('siswa', $siswa->id, 'create', null, $siswa->toArray());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan. Password default: password123');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        return view('admin.siswa.form', ['data' => $siswa, 'kelas' => $kelas]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nisn' => 'nullable|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string',
            'telepon_wali' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $old = $siswa->toArray();
        $siswa->user->update(['name' => $request->nama, 'email' => $request->email, 'username' => $request->nis]);

        $data = $request->only(['nis', 'nisn', 'nama', 'jenis_kelamin', 'kelas_id', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon', 'nama_wali', 'telepon_wali']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);
        AuditLog::catat('siswa', $siswa->id, 'update', $old, $siswa->toArray());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        AuditLog::catat('siswa', $siswa->id, 'delete', $siswa->toArray(), null);
        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->user->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
