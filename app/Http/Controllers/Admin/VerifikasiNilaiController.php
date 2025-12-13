<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{BukuNilai, AuditLog, Notifikasi};
use Illuminate\Http\Request;

class VerifikasiNilaiController extends Controller
{
    public function index()
    {
        $data = BukuNilai::with(['kelas.jurusan', 'mataPelajaran', 'guru', 'semester.tahunAkademik'])
            ->whereIn('status_verifikasi', ['diajukan', 'terverifikasi', 'ditolak'])
            ->latest()
            ->get();
        return view('admin.verifikasi-nilai.index', compact('data'));
    }

    public function show(BukuNilai $bukuNilai)
    {
        $bukuNilai->load(['kelas.jurusan', 'mataPelajaran', 'guru', 'itemNilai.siswa']);
        return view('admin.verifikasi-nilai.show', compact('bukuNilai'));
    }

    public function verifikasi(Request $request, BukuNilai $bukuNilai)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $old = $bukuNilai->toArray();
        $bukuNilai->update([
            'status_verifikasi' => $request->status,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
            'catatan_verifikasi' => $request->catatan,
        ]);
        AuditLog::catat('buku_nilai', $bukuNilai->id, 'verifikasi', $old, $bukuNilai->toArray());

        // Kirim notifikasi ke guru
        $tipe = $request->status === 'terverifikasi' ? 'success' : 'warning';
        $judul = $request->status === 'terverifikasi' ? 'Nilai Diverifikasi' : 'Nilai Ditolak';
        $pesan = "Nilai {$bukuNilai->mataPelajaran->nama} kelas {$bukuNilai->kelas->nama} telah " . 
                 ($request->status === 'terverifikasi' ? 'diverifikasi' : 'ditolak') .
                 ($request->catatan ? ". Catatan: {$request->catatan}" : '');
        
        Notifikasi::kirim($bukuNilai->guru->user_id, $judul, $pesan, $tipe, route('guru.nilai.edit', $bukuNilai));

        $msg = $request->status === 'terverifikasi' ? 'Nilai berhasil diverifikasi' : 'Nilai ditolak, guru akan merevisi';
        return redirect()->route('admin.verifikasi-nilai.index')->with('success', $msg);
    }
}
