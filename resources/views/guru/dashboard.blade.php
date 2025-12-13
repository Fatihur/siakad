@extends('layouts.guru')
@section('title', 'Dashboard Guru')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Dashboard</h2>
    <p class="text-[#64748B]">Selamat datang, {{ $guru->nama }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#EFF4FB] text-primary">
                <i class="fas fa-chalkboard text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['total_kelas'] }}</p>
                <p class="text-sm text-[#64748B]">Kelas Diajar</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#FEF9C3] text-[#CA8A04]">
                <i class="fas fa-tasks text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['tugas_belum_dinilai'] }}</p>
                <p class="text-sm text-[#64748B]">Belum Dinilai</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#E0F2FE] text-meta-5">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['nilai_draft'] }}</p>
                <p class="text-sm text-[#64748B]">Nilai Draft</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#FEF2F2] text-meta-1">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['nilai_ditolak'] }}</p>
                <p class="text-sm text-[#64748B]">Nilai Ditolak</p>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Hari Ini -->
<div class="card">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">Jadwal Mengajar Hari Ini</h3>
        <p class="text-sm text-[#64748B]">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
    </div>
    <div class="p-6">
        @if($jadwalHariIni->count() > 0)
        <div class="space-y-3">
            @foreach($jadwalHariIni as $jadwal)
            <div class="flex items-center justify-between p-4 bg-[#F9FAFB] rounded-lg hover:bg-[#EFF4FB] transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-[#1C2434]">{{ $jadwal->mataPelajaran->nama }}</p>
                        <p class="text-sm text-[#64748B]">{{ $jadwal->kelas->nama }} &bull; {{ $jadwal->ruang->nama }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-[#1C2434]">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                    <a href="{{ route('guru.absensi.create', $jadwal) }}" class="text-sm text-primary hover:underline">
                        <i class="fas fa-clipboard-check mr-1"></i>Absensi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-2xl text-[#9CA3AF]"></i>
            </div>
            <p class="text-[#64748B]">Tidak ada jadwal mengajar hari ini</p>
        </div>
        @endif
    </div>
</div>
@endsection
