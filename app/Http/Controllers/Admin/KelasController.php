<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kelas, Jurusan, AuditLog};
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::with('jurusan')->latest()->get();
        return view('admin.kelas.index', compact('data'));
    }

    public function create()
    {
        $jurusan = Jurusan::where('aktif', true)->get();
        return view('admin.kelas.form', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'nullable|string|max:10',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $kelas = Kelas::create($request->only(['nama', 'tingkat', 'jurusan_id', 'rombel', 'kapasitas']));
        AuditLog::catat('kelas', $kelas->id, 'create', null, $kelas->toArray());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Kelas $kela)
    {
        $jurusan = Jurusan::where('aktif', true)->get();
        return view('admin.kelas.form', ['data' => $kela, 'jurusan' => $jurusan]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'nullable|string|max:10',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $old = $kela->toArray();
        $kela->update($request->only(['nama', 'tingkat', 'jurusan_id', 'rombel', 'kapasitas']));
        AuditLog::catat('kelas', $kela->id, 'update', $old, $kela->toArray());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(Kelas $kela)
    {
        AuditLog::catat('kelas', $kela->id, 'delete', $kela->toArray(), null);
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
