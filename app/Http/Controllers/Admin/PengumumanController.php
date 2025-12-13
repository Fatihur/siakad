<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pengumuman, Kelas, Jurusan, Siswa, User, Notifikasi};
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $data = Pengumuman::with(['kelas', 'jurusan', 'pembuat'])->latest()->get();
        return view('admin.pengumuman.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        $jurusan = Jurusan::where('aktif', true)->get();
        return view('admin.pengumuman.form', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'lingkup' => 'required|in:global,kelas,jurusan',
            'kelas_id' => 'nullable|required_if:lingkup,kelas|exists:kelas,id',
            'jurusan_id' => 'nullable|required_if:lingkup,jurusan|exists:jurusan,id',
            'dipublikasi_pada' => 'nullable|date',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'lingkup' => $request->lingkup,
            'kelas_id' => $request->lingkup === 'kelas' ? $request->kelas_id : null,
            'jurusan_id' => $request->lingkup === 'jurusan' ? $request->jurusan_id : null,
            'dibuat_oleh' => auth()->id(),
            'dipublikasi_pada' => $request->dipublikasi_pada ?? now(),
        ]);

        // Kirim notifikasi berdasarkan lingkup
        $userIds = [];
        if ($request->lingkup === 'global') {
            $userIds = User::whereIn('role', ['guru', 'siswa'])->pluck('id')->toArray();
        } elseif ($request->lingkup === 'kelas') {
            $userIds = Siswa::where('kelas_id', $request->kelas_id)->pluck('user_id')->toArray();
        } elseif ($request->lingkup === 'jurusan') {
            $kelasIds = Kelas::where('jurusan_id', $request->jurusan_id)->pluck('id');
            $userIds = Siswa::whereIn('kelas_id', $kelasIds)->pluck('user_id')->toArray();
        }

        if (!empty($userIds)) {
            Notifikasi::kirimKeSemua($userIds, 'Pengumuman: ' . $request->judul, \Str::limit($request->konten, 100), 'info');
        }

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dibuat');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $kelas = Kelas::with('jurusan')->where('aktif', true)->get();
        $jurusan = Jurusan::where('aktif', true)->get();
        return view('admin.pengumuman.form', ['data' => $pengumuman, 'kelas' => $kelas, 'jurusan' => $jurusan]);
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'lingkup' => 'required|in:global,kelas,jurusan',
            'kelas_id' => 'nullable|required_if:lingkup,kelas|exists:kelas,id',
            'jurusan_id' => 'nullable|required_if:lingkup,jurusan|exists:jurusan,id',
        ]);

        $pengumuman->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'lingkup' => $request->lingkup,
            'kelas_id' => $request->lingkup === 'kelas' ? $request->kelas_id : null,
            'jurusan_id' => $request->lingkup === 'jurusan' ? $request->jurusan_id : null,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
