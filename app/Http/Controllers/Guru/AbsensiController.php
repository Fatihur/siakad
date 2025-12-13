<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, SesiAbsensi, RekapAbsensi, Siswa, Semester, AuditLog};
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        $semester = Semester::getAktif();

        $jadwal = Jadwal::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('semester_id', $semester?->id)
            ->where('dipublikasi', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.absensi.index', compact('jadwal'));
    }

    public function create(Jadwal $jadwal)
    {
        $this->authorize($jadwal);
        $tanggal = Carbon::today();
        
        // Cek apakah sudah ada sesi hari ini
        $sesi = SesiAbsensi::where('jadwal_id', $jadwal->id)->where('tanggal', $tanggal)->first();
        
        if (!$sesi) {
            $pertemuanKe = SesiAbsensi::where('jadwal_id', $jadwal->id)->count() + 1;
            $sesi = SesiAbsensi::create([
                'jadwal_id' => $jadwal->id,
                'tanggal' => $tanggal,
                'pertemuan_ke' => $pertemuanKe,
            ]);
        }

        $siswa = Siswa::where('kelas_id', $jadwal->kelas_id)->where('aktif', true)->orderBy('nama')->get();
        $absensi = RekapAbsensi::where('sesi_absensi_id', $sesi->id)->pluck('status', 'siswa_id');

        return view('guru.absensi.form', compact('jadwal', 'sesi', 'siswa', 'absensi'));
    }

    public function store(Request $request, SesiAbsensi $sesi)
    {
        $jadwal = $sesi->jadwal;
        $this->authorize($jadwal);

        if ($sesi->status === 'ditutup') {
            return back()->withErrors(['error' => 'Sesi absensi sudah ditutup']);
        }

        $request->validate([
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:hadir,izin,sakit,alpha,terlambat',
            'catatan' => 'nullable|array',
        ]);

        foreach ($request->absensi as $siswaId => $status) {
            RekapAbsensi::updateOrCreate(
                ['sesi_absensi_id' => $sesi->id, 'siswa_id' => $siswaId],
                ['status' => $status, 'catatan' => $request->catatan[$siswaId] ?? null]
            );
        }

        AuditLog::catat('sesi_absensi', $sesi->id, 'input_absensi', null, ['count' => count($request->absensi)]);

        return redirect()->route('guru.absensi.index')->with('success', 'Absensi berhasil disimpan');
    }

    public function tutup(SesiAbsensi $sesi)
    {
        $this->authorize($sesi->jadwal);
        $sesi->update(['status' => 'ditutup', 'dikunci_pada' => now()]);
        return back()->with('success', 'Sesi absensi berhasil ditutup');
    }

    public function riwayat(Jadwal $jadwal)
    {
        $this->authorize($jadwal);
        $sesi = SesiAbsensi::with('rekapAbsensi.siswa')
            ->where('jadwal_id', $jadwal->id)
            ->orderByDesc('tanggal')
            ->paginate(10);
        return view('guru.absensi.riwayat', compact('jadwal', 'sesi'));
    }

    private function authorize(Jadwal $jadwal)
    {
        if ($jadwal->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini');
        }
    }
}
