<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{RekapAbsensi, Semester};

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();

        $absensi = RekapAbsensi::with(['sesiAbsensi.jadwal.mataPelajaran'])
            ->whereHas('sesiAbsensi.jadwal', fn($q) => $q->where('kelas_id', $siswa->kelas_id)->where('semester_id', $semester?->id))
            ->where('siswa_id', $siswa->id)
            ->latest('created_at')
            ->paginate(20);

        $rekap = RekapAbsensi::whereHas('sesiAbsensi.jadwal', fn($q) => $q->where('kelas_id', $siswa->kelas_id)->where('semester_id', $semester?->id))
            ->where('siswa_id', $siswa->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('siswa.absensi.index', compact('absensi', 'rekap', 'semester'));
    }
}
