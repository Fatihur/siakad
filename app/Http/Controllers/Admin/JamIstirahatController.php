<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JamIstirahat;
use Illuminate\Http\Request;

class JamIstirahatController extends Controller
{
    public function index()
    {
        $data = JamIstirahat::orderBy('setelah_jam_ke')->get();
        return view('admin.jam-istirahat.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'setelah_jam_ke' => 'required|integer|min:1|max:12',
            'durasi_menit' => 'required|integer|min:5|max:60',
        ]);

        JamIstirahat::create($request->only(['nama', 'setelah_jam_ke', 'durasi_menit']));

        return redirect()->route('admin.jam-istirahat.index')->with('success', 'Jam istirahat berhasil ditambahkan');
    }

    public function update(Request $request, JamIstirahat $jamIstirahat)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'setelah_jam_ke' => 'required|integer|min:1|max:12',
            'durasi_menit' => 'required|integer|min:5|max:60',
        ]);

        $jamIstirahat->update($request->only(['nama', 'setelah_jam_ke', 'durasi_menit']));

        return redirect()->route('admin.jam-istirahat.index')->with('success', 'Jam istirahat berhasil diupdate');
    }

    public function destroy(JamIstirahat $jamIstirahat)
    {
        $jamIstirahat->delete();
        return redirect()->route('admin.jam-istirahat.index')->with('success', 'Jam istirahat berhasil dihapus');
    }

    public function toggle(JamIstirahat $jamIstirahat)
    {
        $jamIstirahat->update(['aktif' => !$jamIstirahat->aktif]);
        return back()->with('success', 'Status jam istirahat berhasil diubah');
    }
}
