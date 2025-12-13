<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MataPelajaran, Guru, AuditLog};
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $data = MataPelajaran::with('guru')->latest()->get();
        return view('admin.mata-pelajaran.index', compact('data'));
    }

    public function create()
    {
        $guru = Guru::where('aktif', true)->orderBy('nama')->get();
        return view('admin.mata-pelajaran.form', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode',
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:wajib,peminatan,muatan_lokal',
            'jam_per_minggu' => 'required|integer|min:1',
            'guru_id' => 'nullable|array',
            'guru_id.*' => 'exists:guru,id',
        ]);

        $mapel = MataPelajaran::create($request->only(['kode', 'nama', 'kelompok', 'jam_per_minggu']));
        
        if ($request->has('guru_id')) {
            $mapel->guru()->sync($request->guru_id);
        }
        
        AuditLog::catat('mata_pelajaran', $mapel->id, 'create', null, $mapel->toArray());

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        $guru = Guru::where('aktif', true)->orderBy('nama')->get();
        $mataPelajaran->load('guru');
        return view('admin.mata-pelajaran.form', ['data' => $mataPelajaran, 'guru' => $guru]);
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode,' . $mataPelajaran->id,
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:wajib,peminatan,muatan_lokal',
            'jam_per_minggu' => 'required|integer|min:1',
            'guru_id' => 'nullable|array',
            'guru_id.*' => 'exists:guru,id',
        ]);

        $old = $mataPelajaran->toArray();
        $mataPelajaran->update($request->only(['kode', 'nama', 'kelompok', 'jam_per_minggu']));
        $mataPelajaran->guru()->sync($request->guru_id ?? []);
        
        AuditLog::catat('mata_pelajaran', $mataPelajaran->id, 'update', $old, $mataPelajaran->toArray());

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diupdate');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        AuditLog::catat('mata_pelajaran', $mataPelajaran->id, 'delete', $mataPelajaran->toArray(), null);
        $mataPelajaran->delete();
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }

    public function getGuru(MataPelajaran $mataPelajaran)
    {
        $guru = $mataPelajaran->guru()->select('guru.id', 'guru.nama', 'guru.nip')->get();
        return response()->json($guru);
    }
}
