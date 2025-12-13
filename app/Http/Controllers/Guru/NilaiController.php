<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{BukuNilai, ItemNilai, Jadwal, Semester, Siswa, AuditLog};
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $bukuNilai = BukuNilai::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->get();

        // Ambil jadwal yang belum punya buku nilai
        $jadwalTanpaBuku = Jadwal::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->whereNotIn('id', function ($q) use ($guru, $semester) {
                $q->select('id')->from('buku_nilai')
                    ->where('guru_id', $guru->id)
                    ->where('semester_id', $semester?->id);
            })
            ->distinct('kelas_id', 'mata_pelajaran_id')
            ->get();

        return view('guru.nilai.index', compact('bukuNilai', 'jadwalTanpaBuku', 'semester'));
    }

    public function create(Request $request)
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ]);

        // Cek apakah sudah ada
        $existing = BukuNilai::where([
            'semester_id' => $semester->id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'guru_id' => $guru->id,
        ])->first();

        if ($existing) {
            return redirect()->route('guru.nilai.edit', $existing);
        }

        $bukuNilai = BukuNilai::create([
            'semester_id' => $semester->id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'guru_id' => $guru->id,
        ]);

        // Buat item nilai untuk semua siswa di kelas
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->where('aktif', true)->get();
        foreach ($siswa as $s) {
            ItemNilai::create(['buku_nilai_id' => $bukuNilai->id, 'siswa_id' => $s->id]);
        }

        return redirect()->route('guru.nilai.edit', $bukuNilai);
    }

    public function edit(BukuNilai $bukuNilai)
    {
        $this->authorize($bukuNilai);
        $bukuNilai->load(['kelas.jurusan', 'mataPelajaran', 'itemNilai.siswa']);
        return view('guru.nilai.form', compact('bukuNilai'));
    }

    public function update(Request $request, BukuNilai $bukuNilai)
    {
        $this->authorize($bukuNilai);

        if ($bukuNilai->status_verifikasi === 'terverifikasi') {
            return back()->withErrors(['error' => 'Nilai sudah terverifikasi, tidak bisa diubah']);
        }

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.nilai_uts' => 'nullable|numeric|min:0|max:100',
            'nilai.*.nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai.*.nilai_sikap' => 'nullable|numeric|min:0|max:100',
            'nilai.*.nilai_keterampilan' => 'nullable|numeric|min:0|max:100',
            'nilai.*.nilai_raport' => 'nullable|numeric|min:0|max:100',
            'nilai.*.catatan' => 'nullable|string',
        ]);

        foreach ($request->nilai as $itemId => $data) {
            ItemNilai::where('id', $itemId)->update($data);
        }

        if ($bukuNilai->status_verifikasi === 'ditolak') {
            $bukuNilai->update(['status_verifikasi' => 'draft', 'catatan_verifikasi' => null]);
        }

        AuditLog::catat('buku_nilai', $bukuNilai->id, 'update_nilai', null, ['count' => count($request->nilai)]);

        return back()->with('success', 'Nilai berhasil disimpan');
    }

    public function ajukan(BukuNilai $bukuNilai)
    {
        $this->authorize($bukuNilai);

        if (!in_array($bukuNilai->status_verifikasi, ['draft', 'ditolak'])) {
            return back()->withErrors(['error' => 'Nilai tidak bisa diajukan']);
        }

        $bukuNilai->update(['status_verifikasi' => 'diajukan']);
        AuditLog::catat('buku_nilai', $bukuNilai->id, 'ajukan_verifikasi', null, null);

        return back()->with('success', 'Nilai berhasil diajukan untuk verifikasi');
    }

    private function authorize(BukuNilai $bukuNilai)
    {
        if ($bukuNilai->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Anda tidak memiliki akses');
        }
    }
}
