<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Tugas, PengumpulanTugas, Jadwal, Semester, Siswa, Notifikasi, MataPelajaran, Kelas};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $data = Tugas::with(['kelas.jurusan', 'mataPelajaran'])
            ->withCount(['pengumpulan', 'pengumpulan as belum_dinilai_count' => fn($q) => $q->whereNull('nilai')])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->latest()
            ->get();

        return view('guru.tugas.index', compact('data'));
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

        return view('guru.tugas.form', compact('jadwal', 'semester'));
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
            'lampiran' => 'nullable|file|max:10240',
            'jenis_pengumpulan' => 'required|in:file,teks,link',
            'deadline' => 'required|date|after:now',
        ]);

        $data = $request->only(['kelas_id', 'mata_pelajaran_id', 'judul', 'deskripsi', 'jenis_pengumpulan', 'deadline']);
        $data['semester_id'] = $semester->id;
        $data['guru_id'] = $guru->id;

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('tugas', 'public');
        }

        $tugas = Tugas::create($data);

        // Kirim notifikasi ke semua siswa di kelas
        $kelas = Kelas::find($request->kelas_id);
        $mapel = MataPelajaran::find($request->mata_pelajaran_id);
        $siswaIds = Siswa::where('kelas_id', $request->kelas_id)->pluck('user_id')->toArray();
        
        Notifikasi::kirimKeSemua(
            $siswaIds,
            'Tugas Baru: ' . $request->judul,
            "Tugas baru dari {$guru->nama} untuk mata pelajaran {$mapel->nama}. Deadline: " . date('d/m/Y H:i', strtotime($request->deadline)),
            'info',
            route('siswa.tugas.show', $tugas)
        );

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dibuat');
    }

    public function show(Tugas $tuga)
    {
        $this->authorize($tuga);
        $tuga->load(['kelas.jurusan', 'mataPelajaran', 'pengumpulan.siswa']);
        return view('guru.tugas.show', ['tugas' => $tuga]);
    }

    public function edit(Tugas $tuga)
    {
        $this->authorize($tuga);
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $jadwal = Jadwal::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->get()
            ->unique(fn($j) => $j->kelas_id . '-' . $j->mata_pelajaran_id);

        return view('guru.tugas.form', ['data' => $tuga, 'jadwal' => $jadwal, 'semester' => $semester]);
    }

    public function update(Request $request, Tugas $tuga)
    {
        $this->authorize($tuga);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|max:10240',
            'jenis_pengumpulan' => 'required|in:file,teks,link',
            'deadline' => 'required|date',
        ]);

        $data = $request->only(['kelas_id', 'mata_pelajaran_id', 'judul', 'deskripsi', 'jenis_pengumpulan', 'deadline']);

        if ($request->hasFile('lampiran')) {
            if ($tuga->lampiran) Storage::disk('public')->delete($tuga->lampiran);
            $data['lampiran'] = $request->file('lampiran')->store('tugas', 'public');
        }

        $tuga->update($data);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diupdate');
    }

    public function destroy(Tugas $tuga)
    {
        $this->authorize($tuga);
        if ($tuga->lampiran) Storage::disk('public')->delete($tuga->lampiran);
        $tuga->delete();
        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dihapus');
    }

    public function nilaiPengumpulan(Request $request, PengumpulanTugas $pengumpulan)
    {
        $this->authorize($pengumpulan->tugas);

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $pengumpulan->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
            'dinilai_pada' => now(),
        ]);

        return back()->with('success', 'Nilai berhasil disimpan');
    }

    private function authorize(Tugas $tugas)
    {
        if ($tugas->guru_id !== auth()->user()->guru->id) {
            abort(403);
        }
    }
}
