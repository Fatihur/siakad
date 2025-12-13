<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Tugas, PengumpulanTugas, Semester};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();

        $tugas = Tugas::with(['mataPelajaran', 'guru'])
            ->withCount(['pengumpulan as sudah_dikumpulkan' => fn($q) => $q->where('siswa_id', $siswa->id)])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semester?->id)
            ->latest()
            ->paginate(10);

        return view('siswa.tugas.index', compact('tugas', 'semester'));
    }

    public function show(Tugas $tuga)
    {
        $siswa = auth()->user()->siswa;
        
        if ($tuga->kelas_id !== $siswa->kelas_id) {
            abort(403);
        }

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tuga->id)->where('siswa_id', $siswa->id)->first();

        return view('siswa.tugas.show', ['tugas' => $tuga, 'pengumpulan' => $pengumpulan]);
    }

    public function kumpulkan(Request $request, Tugas $tuga)
    {
        $siswa = auth()->user()->siswa;

        if ($tuga->kelas_id !== $siswa->kelas_id) {
            abort(403);
        }

        if ($tuga->ditutup) {
            return back()->withErrors(['error' => 'Tugas sudah ditutup']);
        }

        $rules = ['konten' => 'nullable|string'];
        if ($tuga->jenis_pengumpulan === 'file') {
            $rules['file'] = 'required|file|max:10240';
        } elseif ($tuga->jenis_pengumpulan === 'link') {
            $rules['url_link'] = 'required|url';
        } else {
            $rules['konten'] = 'required|string';
        }

        $request->validate($rules);

        $data = [
            'tugas_id' => $tuga->id,
            'siswa_id' => $siswa->id,
            'dikumpulkan_pada' => now(),
            'terlambat' => now()->gt($tuga->deadline),
            'konten' => $request->konten,
            'url_link' => $request->url_link,
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('pengumpulan', 'public');
        }

        // Update jika sudah ada
        $existing = PengumpulanTugas::where('tugas_id', $tuga->id)->where('siswa_id', $siswa->id)->first();
        if ($existing) {
            if ($existing->file_path && $request->hasFile('file')) {
                Storage::disk('public')->delete($existing->file_path);
            }
            $existing->update($data);
        } else {
            PengumpulanTugas::create($data);
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan');
    }
}
