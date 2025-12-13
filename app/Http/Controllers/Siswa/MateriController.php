<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Materi, Semester};

class MateriController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $semester = Semester::getAktif();

        $materi = Materi::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semester?->id)
            ->where('visibilitas', 'publik')
            ->latest()
            ->paginate(10);

        return view('siswa.materi.index', compact('materi', 'semester'));
    }
}
