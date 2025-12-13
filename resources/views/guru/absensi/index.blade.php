@extends('layouts.guru')
@section('title', 'Absensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Absensi Siswa</h2>
    <p class="text-[#64748B]">Pilih jadwal untuk melakukan absensi</p>
</div>

@php
    $hariMap = ['senin' => 1, 'selasa' => 2, 'rabu' => 3, 'kamis' => 4, 'jumat' => 5, 'sabtu' => 6, 'minggu' => 0];
    $hariIni = now()->dayOfWeek;
@endphp

<!-- Info Hari Ini -->
<div class="card bg-primary mb-6">
    <div class="p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-calendar-day text-xl"></i>
        </div>
        <div class="text-white">
            <p class="text-white/80 text-sm">Hari Ini</p>
            <p class="text-xl font-bold">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">Daftar Jadwal</h3>
    </div>
    <div class="p-6">
        @if($jadwal->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($jadwal as $j)
            @php $isHariIni = ($hariMap[strtolower($j->hari)] ?? null) === $hariIni; @endphp
            <div class="relative border {{ $isHariIni ? 'border-primary bg-[#EFF4FB]' : 'border-stroke' }} rounded-lg p-5 {{ !$isHariIni ? 'opacity-60' : '' }}">
                @if($isHariIni)
                <div class="absolute -top-2.5 left-4">
                    <span class="badge badge-success text-xs">
                        <i class="fas fa-circle text-[5px] mr-1 animate-pulse"></i> Hari Ini
                    </span>
                </div>
                @endif
                
                <div class="flex items-start gap-4 mt-1">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 {{ $isHariIni ? 'bg-primary text-white' : 'bg-[#F9FAFB] text-[#64748B]' }}">
                        <i class="fas fa-book text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-[#1C2434] truncate">{{ $j->mataPelajaran->nama }}</h4>
                        <p class="text-sm text-[#64748B]">{{ $j->kelas->nama }}</p>
                    </div>
                </div>
                
                <div class="mt-4 space-y-2 text-sm text-[#64748B]">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar w-4 text-center"></i>
                        <span>{{ ucfirst($j->hari) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock w-4 text-center"></i>
                        <span>{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</span>
                    </div>
                </div>
                
                <div class="mt-5 flex gap-2">
                    @if($isHariIni)
                    <a href="{{ route('guru.absensi.create', $j) }}" class="btn btn-primary flex-1 text-sm py-2">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Mulai Absensi</span>
                    </a>
                    @else
                    <span class="btn bg-[#E2E8F0] text-[#64748B] flex-1 text-sm py-2 cursor-not-allowed">
                        <i class="fas fa-lock"></i>
                        <span>Tidak Tersedia</span>
                    </span>
                    @endif
                    <a href="{{ route('guru.absensi.riwayat', $j) }}" class="btn btn-outline text-sm py-2 px-3" title="Riwayat">
                        <i class="fas fa-history"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="font-semibold text-[#1C2434] mb-1">Tidak ada jadwal</h3>
            <p class="text-[#64748B]">Anda belum memiliki jadwal mengajar</p>
        </div>
        @endif
    </div>
</div>
@endsection
