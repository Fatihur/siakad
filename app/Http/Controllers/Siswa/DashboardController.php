<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Semester, Tugas, Pengumuman, RekapAbsensi};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();
        $hari = strtolower(Carbon::now()->locale('id')->dayName);

        $jadwalHariIni = Jadwal::with(['mataPelajaran', 'guru', 'ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semester?->id)
            ->where('hari', $hari)
            ->where('dipublikasi', true)
            ->orderBy('jam_mulai')
            ->get();

        $tugasAktif = Tugas::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semester?->id)
            ->where('deadline', '>', now())
            ->where('ditutup', false)
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $pengumuman = Pengumuman::where('aktif', true)
            ->where(function ($q) use ($siswa) {
                $q->where('lingkup', 'global')
                    ->orWhere(fn($q2) => $q2->where('lingkup', 'kelas')->where('kelas_id', $siswa->kelas_id))
                    ->orWhere(fn($q2) => $q2->where('lingkup', 'jurusan')->where('jurusan_id', $siswa->kelas->jurusan_id));
            })
            ->where('dipublikasi_pada', '<=', now())
            ->latest('dipublikasi_pada')
            ->take(5)
            ->get();

        // Rekap absensi
        $absensi = RekapAbsensi::whereHas('sesiAbsensi.jadwal', fn($q) => $q->where('kelas_id', $siswa->kelas_id)->where('semester_id', $semester?->id))
            ->where('siswa_id', $siswa->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('siswa.dashboard', compact('jadwalHariIni', 'tugasAktif', 'pengumuman', 'absensi', 'siswa', 'semester'));
    }
}
