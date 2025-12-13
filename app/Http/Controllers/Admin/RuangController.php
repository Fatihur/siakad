<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Ruang, AuditLog};
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $data = Ruang::latest()->get();
        return view('admin.ruang.index', compact('data'));
    }

    public function create()
    {
        return view('admin.ruang.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:ruang,kode',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'tipe' => 'required|in:teori,lab,praktik',
        ]);

        $ruang = Ruang::create($request->only(['kode', 'nama', 'kapasitas', 'tipe']));
        AuditLog::catat('ruang', $ruang->id, 'create', null, $ruang->toArray());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil ditambahkan');
    }

    public function edit(Ruang $ruang)
    {
        return view('admin.ruang.form', ['data' => $ruang]);
    }

    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:ruang,kode,' . $ruang->id,
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'tipe' => 'required|in:teori,lab,praktik',
        ]);

        $old = $ruang->toArray();
        $ruang->update($request->only(['kode', 'nama', 'kapasitas', 'tipe']));
        AuditLog::catat('ruang', $ruang->id, 'update', $old, $ruang->toArray());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil diupdate');
    }

    public function destroy(Ruang $ruang)
    {
        AuditLog::catat('ruang', $ruang->id, 'delete', $ruang->toArray(), null);
        $ruang->delete();
        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil dihapus');
    }
}
