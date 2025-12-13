@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Dashboard</h2>
    <p class="text-[#64748B]">Selamat datang, {{ $siswa->nama }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="stat-icon bg-[#ECFDF3] text-meta-3 w-10 h-10">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-[#1C2434]">{{ $absensi['hadir'] ?? 0 }}</p>
                <p class="text-xs text-[#64748B]">Hadir</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="stat-icon bg-[#FEF9C3] text-[#CA8A04] w-10 h-10">
                <i class="fas fa-envelope"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-[#1C2434]">{{ $absensi['izin'] ?? 0 }}</p>
                <p class="text-xs text-[#64748B]">Izin</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="stat-icon bg-[#E0F2FE] text-meta-5 w-10 h-10">
                <i class="fas fa-medkit"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-[#1C2434]">{{ $absensi['sakit'] ?? 0 }}</p>
                <p class="text-xs text-[#64748B]">Sakit</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="stat-icon bg-[#FEF2F2] text-meta-1 w-10 h-10">
                <i class="fas fa-times"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-[#1C2434]">{{ $absensi['alpha'] ?? 0 }}</p>
                <p class="text-xs text-[#64748B]">Alpha</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Jadwal Hari Ini -->
    <div class="xl:col-span-2 card">
        <div class="px-6 py-4 border-b border-stroke">
            <h3 class="font-semibold text-[#1C2434]">Jadwal Hari Ini</h3>
            <p class="text-sm text-[#64748B]">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="p-6">
            @if($jadwalHariIni->count() > 0)
            <div class="space-y-3">
                @foreach($jadwalHariIni as $jadwal)
                <div class="flex items-center justify-between p-4 bg-[#F9FAFB] rounded-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-[#1C2434]">{{ $jadwal->mataPelajaran->nama }}</p>
                            <p class="text-sm text-[#64748B]">{{ $jadwal->guru->nama }} &bull; {{ $jadwal->ruang->nama }}</p>
                        </div>
                    </div>
                    <p class="font-semibold text-primary">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-2xl text-[#9CA3AF]"></i>
                </div>
                <p class="text-[#64748B]">Tidak ada jadwal hari ini</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tugas Aktif -->
    <div class="card">
        <div class="px-6 py-4 border-b border-stroke flex justify-between items-center">
            <h3 class="font-semibold text-[#1C2434]">Tugas Aktif</h3>
            <a href="{{ route('siswa.tugas.index') }}" class="text-sm text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            @if($tugasAktif->count() > 0)
            <div class="space-y-3">
                @foreach($tugasAktif as $tugas)
                <a href="{{ route('siswa.tugas.show', $tugas) }}" class="block p-4 border border-stroke rounded-lg hover:border-primary hover:shadow-card transition-all">
                    <p class="font-medium text-[#1C2434]">{{ Str::limit($tugas->judul, 30) }}</p>
                    <p class="text-xs text-[#64748B] mt-1">{{ $tugas->mataPelajaran->nama }}</p>
                    <p class="text-xs text-meta-1 mt-2">
                        <i class="fas fa-clock mr-1"></i>{{ $tugas->deadline->diffForHumans() }}
                    </p>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-6">
                <div class="w-14 h-14 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check-circle text-xl text-[#9CA3AF]"></i>
                </div>
                <p class="text-[#64748B] text-sm">Tidak ada tugas aktif</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Pengumuman -->
@if($pengumuman->count() > 0)
<div class="mt-6 card">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">Pengumuman Terbaru</h3>
    </div>
    <div class="p-6 space-y-4">
        @foreach($pengumuman as $p)
        <div class="flex gap-4 p-4 bg-[#F9FAFB] rounded-lg">
            <div class="w-1 bg-primary rounded-full flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-[#1C2434]">{{ $p->judul }}</p>
                <p class="text-sm text-[#64748B] mt-1">{{ Str::limit($p->konten, 150) }}</p>
                <p class="text-xs text-[#9CA3AF] mt-2">
                    <i class="fas fa-calendar mr-1"></i>{{ $p->dipublikasi_pada->format('d M Y') }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
