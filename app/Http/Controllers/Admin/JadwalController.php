<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Semester, Kelas, MataPelajaran, Guru, Ruang, JamIstirahat, AuditLog};
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $semester = Semester::getAktif();
        $data = Jadwal::with(['kelas.jurusan', 'mataPelajaran', 'guru', 'ruang'])
            ->when($semester, fn($q) => $q->where('semester_id', $semester->id))
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
        $jamIstirahat = JamIstirahat::getAktif();
        return view('admin.jadwal.index', compact('data', 'semester', 'jamIstirahat'));
    }

    public function create()
    {
        $semester = Semester::getAktif();
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        $mapel = MataPelajaran::where('aktif', true)->get();
        $ruang = Ruang::where('aktif', true)->get();
        return view('admin.jadwal.form', compact('semester', 'kelas', 'mapel', 'ruang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semester,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'ruang_id' => 'required|exists:ruang,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek konflik
        $konflik = $this->cekKonflik($request);
        if ($konflik) {
            return back()->withErrors(['konflik' => $konflik])->withInput();
        }

        $jadwal = Jadwal::create($request->only(['semester_id', 'kelas_id', 'mata_pelajaran_id', 'guru_id', 'ruang_id', 'hari', 'jam_mulai', 'jam_selesai']));
        AuditLog::catat('jadwal', $jadwal->id, 'create', null, $jadwal->toArray());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Jadwal $jadwal)
    {
        $semester = Semester::getAktif();
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        $mapel = MataPelajaran::where('aktif', true)->get();
        $ruang = Ruang::where('aktif', true)->get();
        return view('admin.jadwal.form', ['data' => $jadwal, 'semester' => $semester, 'kelas' => $kelas, 'mapel' => $mapel, 'ruang' => $ruang]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'semester_id' => 'required|exists:semester,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'ruang_id' => 'required|exists:ruang,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $konflik = $this->cekKonflik($request, $jadwal->id);
        if ($konflik) {
            return back()->withErrors(['konflik' => $konflik])->withInput();
        }

        $old = $jadwal->toArray();
        $jadwal->update($request->only(['semester_id', 'kelas_id', 'mata_pelajaran_id', 'guru_id', 'ruang_id', 'hari', 'jam_mulai', 'jam_selesai']));
        AuditLog::catat('jadwal', $jadwal->id, 'update', $old, $jadwal->toArray());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy(Jadwal $jadwal)
    {
        AuditLog::catat('jadwal', $jadwal->id, 'delete', $jadwal->toArray(), null);
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function generator()
    {
        $semester = Semester::getAktif();
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        $mapel = MataPelajaran::where('aktif', true)->get();
        $ruang = Ruang::where('aktif', true)->get();
        $jamIstirahat = JamIstirahat::getAktif();
        return view('admin.jadwal.generator', compact('semester', 'kelas', 'mapel', 'ruang', 'jamIstirahat'));
    }

    public function generatorStore(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semester,id',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi' => 'required|integer|min:30|max:60',
            'jam_mulai_default' => 'required',
        ]);

        $jadwalData = $request->input('jadwal', []);
        $durasi = (int) $request->durasi;
        $jamMulaiDefault = $request->jam_mulai_default;
        $created = 0;
        $errors = [];
        $hari_list = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        
        // Get active break times
        $jamIstirahat = JamIstirahat::getAktif()->keyBy('setelah_jam_ke');

        foreach ($jadwalData as $jamKe => $hariData) {
            foreach ($hariData as $hari => $data) {
                if (empty($data['mapel']) || empty($data['guru']) || empty($data['ruang'])) {
                    continue;
                }

                // Hitung jam mulai dan selesai berdasarkan jam ke, dengan memperhitungkan istirahat
                $totalIstirahatMenit = 0;
                foreach ($jamIstirahat as $afterJam => $istirahat) {
                    if ($afterJam < $jamKe) {
                        $totalIstirahatMenit += $istirahat->durasi_menit;
                    }
                }
                
                $startMinutes = $this->hitungMenit($jamMulaiDefault) + (($jamKe - 1) * $durasi) + $totalIstirahatMenit;
                $endMinutes = $startMinutes + $durasi;
                $jamMulai = $this->menitKeWaktu($startMinutes);
                $jamSelesai = $this->menitKeWaktu($endMinutes);

                // Ambil guru_id - bisa dari form atau dari relasi mapel
                $guruId = $data['guru'];
                
                // Cek konflik
                $fakeRequest = new Request([
                    'semester_id' => $request->semester_id,
                    'kelas_id' => $request->kelas_id,
                    'mata_pelajaran_id' => $data['mapel'],
                    'guru_id' => $guruId,
                    'ruang_id' => $data['ruang'],
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                ]);

                $konflik = $this->cekKonflik($fakeRequest);
                if ($konflik) {
                    $errors[] = "Jam ke-{$jamKe} hari " . ucfirst($hari) . ": {$konflik}";
                    continue;
                }

                // Buat jadwal
                $jadwal = Jadwal::create([
                    'semester_id' => $request->semester_id,
                    'kelas_id' => $request->kelas_id,
                    'mata_pelajaran_id' => $data['mapel'],
                    'guru_id' => $guruId,
                    'ruang_id' => $data['ruang'],
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                ]);

                AuditLog::catat('jadwal', $jadwal->id, 'create', null, $jadwal->toArray());
                $created++;
            }
        }

        if ($created === 0 && count($errors) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat jadwal. ' . implode('; ', $errors)
            ], 422);
        }

        $message = "{$created} jadwal berhasil dibuat.";
        if (count($errors) > 0) {
            $message .= " " . count($errors) . " jadwal gagal karena konflik.";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'created' => $created,
            'errors' => $errors
        ]);
    }

    private function hitungMenit($waktu)
    {
        $parts = explode(':', $waktu);
        return (int)$parts[0] * 60 + (int)$parts[1];
    }

    private function menitKeWaktu($menit)
    {
        $jam = floor($menit / 60);
        $min = $menit % 60;
        return sprintf('%02d:%02d', $jam, $min);
    }

    private function cekKonflik(Request $request, $excludeId = null)
    {
        $query = Jadwal::where('semester_id', $request->semester_id)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            });

        if ($excludeId) $query->where('id', '!=', $excludeId);

        // Cek guru bentrok
        $guruBentrok = (clone $query)->where('guru_id', $request->guru_id)->exists();
        if ($guruBentrok) return 'Guru sudah memiliki jadwal di waktu tersebut';

        // Cek ruang bentrok
        $ruangBentrok = (clone $query)->where('ruang_id', $request->ruang_id)->exists();
        if ($ruangBentrok) return 'Ruang sudah digunakan di waktu tersebut';

        // Cek kelas bentrok
        $kelasBentrok = (clone $query)->where('kelas_id', $request->kelas_id)->exists();
        if ($kelasBentrok) return 'Kelas sudah memiliki jadwal di waktu tersebut';

        return null;
    }
}
