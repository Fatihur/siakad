<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MataPelajaran, AuditLog};
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $data = MataPelajaran::latest()->get();
        return view('admin.mata-pelajaran.index', compact('data'));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode',
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:wajib,peminatan,muatan_lokal',
            'jam_per_minggu' => 'required|integer|min:1',
        ]);

        $mapel = MataPelajaran::create($request->only(['kode', 'nama', 'kelompok', 'jam_per_minggu']));
        AuditLog::catat('mata_pelajaran', $mapel->id, 'create', null, $mapel->toArray());

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.form', ['data' => $mataPelajaran]);
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode,' . $mataPelajaran->id,
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:wajib,peminatan,muatan_lokal',
            'jam_per_minggu' => 'required|integer|min:1',
        ]);

        $old = $mataPelajaran->toArray();
        $mataPelajaran->update($request->only(['kode', 'nama', 'kelompok', 'jam_per_minggu']));
        AuditLog::catat('mata_pelajaran', $mataPelajaran->id, 'update', $old, $mataPelajaran->toArray());

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diupdate');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        AuditLog::catat('mata_pelajaran', $mataPelajaran->id, 'delete', $mataPelajaran->toArray(), null);
        $mataPelajaran->delete();
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }
}
