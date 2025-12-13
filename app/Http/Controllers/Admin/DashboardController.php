<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Guru, Siswa, Kelas, Jadwal, BukuNilai, Semester};

class DashboardController extends Controller
{
    public function index()
    {
        $semester = Semester::getAktif();
        
        $stats = [
            'total_guru' => Guru::where('aktif', true)->count(),
            'total_siswa' => Siswa::where('aktif', true)->count(),
            'total_kelas' => Kelas::where('aktif', true)->count(),
            'jadwal_aktif' => $semester ? Jadwal::where('semester_id', $semester->id)->where('dipublikasi', true)->count() : 0,
            'nilai_pending' => BukuNilai::where('status_verifikasi', 'diajukan')->count(),
            'nilai_terverifikasi' => BukuNilai::where('status_verifikasi', 'terverifikasi')->count(),
        ];

        $nilaiPending = BukuNilai::with(['kelas', 'mataPelajaran', 'guru'])
            ->where('status_verifikasi', 'diajukan')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'nilaiPending', 'semester'));
    }
}
