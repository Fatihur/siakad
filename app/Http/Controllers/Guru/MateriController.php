<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Materi, Jadwal, Semester, Kelas, MataPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $data = Materi::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->latest()
            ->get();

        return view('guru.materi.index', compact('data'));
    }

    public function create()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $jadwal = Jadwal::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->get()
            ->unique(fn($j) => $j->kelas_id . '-' . $j->mata_pelajaran_id);

        return view('guru.materi.form', compact('jadwal', 'semester'));
    }

    public function store(Request $request)
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'url_link' => 'nullable|url',
            'visibilitas' => 'required|in:draft,publik',
        ]);

        $data = $request->only(['kelas_id', 'mata_pelajaran_id', 'judul', 'deskripsi', 'url_link', 'visibilitas']);
        $data['semester_id'] = $semester->id;
        $data['guru_id'] = $guru->id;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('materi', 'public');
        }

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit(Materi $materi)
    {
        $this->authorize($materi);
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $jadwal = Jadwal::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->get()
            ->unique(fn($j) => $j->kelas_id . '-' . $j->mata_pelajaran_id);

        return view('guru.materi.form', ['data' => $materi, 'jadwal' => $jadwal, 'semester' => $semester]);
    }

    public function update(Request $request, Materi $materi)
    {
        $this->authorize($materi);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'url_link' => 'nullable|url',
            'visibilitas' => 'required|in:draft,publik',
        ]);

        $data = $request->only(['kelas_id', 'mata_pelajaran_id', 'judul', 'deskripsi', 'url_link', 'visibilitas']);

        if ($request->hasFile('file')) {
            if ($materi->file_path) Storage::disk('public')->delete($materi->file_path);
            $data['file_path'] = $request->file('file')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(Materi $materi)
    {
        $this->authorize($materi);
        if ($materi->file_path) Storage::disk('public')->delete($materi->file_path);
        $materi->delete();
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus');
    }

    private function authorize(Materi $materi)
    {
        if ($materi->guru_id !== auth()->user()->guru->id) {
            abort(403);
        }
    }
}
