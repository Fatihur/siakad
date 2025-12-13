<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jurusan, AuditLog};
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $data = Jurusan::latest()->get();
        return view('admin.jurusan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.jurusan.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:jurusan,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jurusan = Jurusan::create($request->only(['kode', 'nama', 'deskripsi']));
        AuditLog::catat('jurusan', $jurusan->id, 'create', null, $jurusan->toArray());

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.form', ['data' => $jurusan]);
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:jurusan,kode,' . $jurusan->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $old = $jurusan->toArray();
        $jurusan->update($request->only(['kode', 'nama', 'deskripsi']));
        AuditLog::catat('jurusan', $jurusan->id, 'update', $old, $jurusan->toArray());

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate');
    }

    public function destroy(Jurusan $jurusan)
    {
        AuditLog::catat('jurusan', $jurusan->id, 'delete', $jurusan->toArray(), null);
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
