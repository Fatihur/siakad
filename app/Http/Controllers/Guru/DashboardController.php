<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Semester, Tugas, BukuNilai, SesiAbsensi};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();
        $hari = strtolower(Carbon::now()->locale('id')->dayName);

        $jadwalHariIni = Jadwal::with(['kelas.jurusan', 'mataPelajaran', 'ruang'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->where('hari', $hari)
            ->where('dipublikasi', true)
            ->orderBy('jam_mulai')
            ->get();

        $stats = [
            'total_kelas' => Jadwal::where('guru_id', $guru->id)->where('semester_id', $semester?->id)->distinct('kelas_id')->count('kelas_id'),
            'tugas_belum_dinilai' => Tugas::where('guru_id', $guru->id)->whereHas('pengumpulan', fn($q) => $q->whereNull('nilai'))->count(),
            'nilai_draft' => BukuNilai::where('guru_id', $guru->id)->where('status_verifikasi', 'draft')->count(),
            'nilai_ditolak' => BukuNilai::where('guru_id', $guru->id)->where('status_verifikasi', 'ditolak')->count(),
        ];

        return view('guru.dashboard', compact('jadwalHariIni', 'stats', 'semester', 'guru'));
    }
}
