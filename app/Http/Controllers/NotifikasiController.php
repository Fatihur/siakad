<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function baca(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== auth()->id()) {
            abort(403);
        }

        $notifikasi->update(['dibaca_pada' => now()]);

        if ($notifikasi->link) {
            return redirect($notifikasi->link);
        }

        return back();
    }

    public function bacaSemua()
    {
        Notifikasi::where('user_id', auth()->id())
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);

        return back()->with('success', 'Semua notifikasi telah dibaca');
    }

    public function hapus(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== auth()->id()) {
            abort(403);
        }

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi dihapus');
    }

    public function getUnread()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->belumDibaca()
            ->latest()
            ->take(5)
            ->get();

        $count = Notifikasi::where('user_id', auth()->id())
            ->belumDibaca()
            ->count();

        return response()->json([
            'count' => $count,
            'notifikasi' => $notifikasi,
        ]);
    }
}
