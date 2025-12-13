<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Semester};

class JadwalController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();

        $jadwal = Jadwal::with(['mataPelajaran', 'guru', 'ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semester?->id)
            ->where('dipublikasi', true)
            ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('siswa.jadwal.index', compact('jadwal', 'semester'));
    }
}
