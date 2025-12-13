@extends('layouts.guru')
@section('title', 'Riwayat Absensi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
    <p class="text-gray-500">{{ $jadwal->mataPelajaran->nama }} - {{ $jadwal->kelas->nama }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="font-semibold">Daftar Pertemuan</h2>
        <a href="{{ route('guru.absensi.index') }}" class="text-indigo-600 hover:underline text-sm">Kembali</a>
    </div>
    <div class="p-6">
        @if($sesi->count() > 0)
        <div class="space-y-4">
            @foreach($sesi as $s)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <p class="font-medium">Pertemuan ke-{{ $s->pertemuan_ke }}</p>
                        <p class="text-sm text-gray-500">{{ $s->tanggal->format('d F Y') }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs {{ $s->status == 'ditutup' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($s->status) }}
                    </span>
                </div>
                <div class="flex gap-4 text-sm">
                    @php
                        $rekap = $s->rekapAbsensi->groupBy('status')->map->count();
                    @endphp
                    <span class="text-green-600"><i class="fas fa-check mr-1"></i>Hadir: {{ $rekap['hadir'] ?? 0 }}</span>
                    <span class="text-yellow-600"><i class="fas fa-envelope mr-1"></i>Izin: {{ $rekap['izin'] ?? 0 }}</span>
                    <span class="text-blue-600"><i class="fas fa-medkit mr-1"></i>Sakit: {{ $rekap['sakit'] ?? 0 }}</span>
                    <span class="text-red-600"><i class="fas fa-times mr-1"></i>Alpha: {{ $rekap['alpha'] ?? 0 }}</span>
                </div>
            </div>
            @endforeach
        </div>
        {{ $sesi->links() }}
        @else
        <p class="text-gray-500 text-center py-4">Belum ada riwayat absensi</p>
        @endif
    </div>
</div>
@endsection
