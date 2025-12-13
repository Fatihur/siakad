<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{TahunAkademik, Semester, AuditLog};
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $data = TahunAkademik::with('semester')->latest()->get();
        return view('admin.tahun-akademik.index', compact('data'));
    }

    public function create()
    {
        return view('admin.tahun-akademik.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:9|unique:tahun_akademik,tahun',
        ]);

        $tahun = TahunAkademik::create($request->only('tahun'));
        
        // Buat semester ganjil dan genap
        Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'ganjil']);
        Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'genap']);

        AuditLog::catat('tahun_akademik', $tahun->id, 'create', null, $tahun->toArray());

        return redirect()->route('admin.tahun-akademik.index')->with('success', 'Tahun akademik berhasil ditambahkan');
    }

    public function edit(TahunAkademik $tahunAkademik)
    {
        return view('admin.tahun-akademik.form', ['data' => $tahunAkademik]);
    }

    public function update(Request $request, TahunAkademik $tahunAkademik)
    {
        $request->validate([
            'tahun' => 'required|string|max:9|unique:tahun_akademik,tahun,' . $tahunAkademik->id,
        ]);

        $old = $tahunAkademik->toArray();
        $tahunAkademik->update($request->only('tahun'));
        AuditLog::catat('tahun_akademik', $tahunAkademik->id, 'update', $old, $tahunAkademik->toArray());

        return redirect()->route('admin.tahun-akademik.index')->with('success', 'Tahun akademik berhasil diupdate');
    }

    public function destroy(TahunAkademik $tahunAkademik)
    {
        AuditLog::catat('tahun_akademik', $tahunAkademik->id, 'delete', $tahunAkademik->toArray(), null);
        $tahunAkademik->delete();
        return redirect()->route('admin.tahun-akademik.index')->with('success', 'Tahun akademik berhasil dihapus');
    }

    public function setAktif(TahunAkademik $tahunAkademik)
    {
        TahunAkademik::where('aktif', true)->update(['aktif' => false]);
        $tahunAkademik->update(['aktif' => true]);
        return back()->with('success', 'Tahun akademik aktif berhasil diubah');
    }

    public function setSemesterAktif(Semester $semester)
    {
        Semester::where('aktif', true)->update(['aktif' => false]);
        $semester->update(['aktif' => true]);
        return back()->with('success', 'Semester aktif berhasil diubah');
    }
}
