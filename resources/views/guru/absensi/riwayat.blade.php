@extends('layouts.guru')
@section('title', 'Riwayat Absensi')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('guru.absensi.index') }}" class="hover:text-primary">Absensi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>Riwayat</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">Riwayat Absensi</h2>
    <p class="text-[#64748B]">{{ $jadwal->mataPelajaran->nama }} - {{ $jadwal->kelas->nama }}</p>
</div>

<div class="card">
    <div class="px-6 py-4 border-b border-stroke flex justify-between items-center">
        <h3 class="font-semibold text-[#1C2434]">Daftar Pertemuan</h3>
        <a href="{{ route('guru.absensi.index') }}" class="btn btn-outline text-sm">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    <div class="p-6">
        @if($sesi->count() > 0)
        <div class="space-y-4">
            @foreach($sesi as $s)
            @php
                $rekap = $s->rekapAbsensi->groupBy('status')->map->count();
            @endphp
            <div class="border border-stroke rounded-lg p-5 hover:border-primary hover:shadow-card transition-all">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-white font-bold">
                            {{ $s->pertemuan_ke }}
                        </div>
                        <div>
                            <p class="font-semibold text-[#1C2434]">Pertemuan ke-{{ $s->pertemuan_ke }}</p>
                            <p class="text-sm text-[#64748B]">{{ $s->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                    </div>
                    <span class="badge {{ $s->status == 'ditutup' ? 'badge-danger' : 'badge-success' }}">
                        <i class="fas {{ $s->status == 'ditutup' ? 'fa-lock' : 'fa-lock-open' }} mr-1"></i>
                        {{ ucfirst($s->status) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#ECFDF3] rounded-lg">
                        <i class="fas fa-check text-meta-3"></i>
                        <span class="text-sm">Hadir: <strong class="text-meta-3">{{ $rekap['hadir'] ?? 0 }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#E0F2FE] rounded-lg">
                        <i class="fas fa-envelope text-meta-5"></i>
                        <span class="text-sm">Izin: <strong class="text-meta-5">{{ $rekap['izin'] ?? 0 }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#F0F9FF] rounded-lg">
                        <i class="fas fa-medkit text-meta-10"></i>
                        <span class="text-sm">Sakit: <strong class="text-meta-10">{{ $rekap['sakit'] ?? 0 }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#FEF2F2] rounded-lg">
                        <i class="fas fa-times text-meta-1"></i>
                        <span class="text-sm">Alpha: <strong class="text-meta-1">{{ $rekap['alpha'] ?? 0 }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#FEF9C3] rounded-lg">
                        <i class="fas fa-clock text-meta-6"></i>
                        <span class="text-sm">Terlambat: <strong class="text-meta-6">{{ $rekap['terlambat'] ?? 0 }}</strong></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $sesi->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="font-semibold text-[#1C2434] mb-1">Belum ada riwayat</h3>
            <p class="text-[#64748B]">Belum ada absensi yang tercatat</p>
        </div>
        @endif
    </div>
</div>
@endsection
