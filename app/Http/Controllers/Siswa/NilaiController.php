<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{ItemNilai, Semester};

class NilaiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();

        $nilai = ItemNilai::with(['bukuNilai.mataPelajaran', 'bukuNilai.guru'])
            ->whereHas('bukuNilai', fn($q) => $q->where('kelas_id', $siswa->kelas_id)
                ->where('semester_id', $semester?->id)
                ->where('status_verifikasi', 'terverifikasi'))
            ->where('siswa_id', $siswa->id)
            ->get();

        return view('siswa.nilai.index', compact('nilai', 'semester'));
    }
}
