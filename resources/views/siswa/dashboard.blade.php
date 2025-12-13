@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500">Selamat datang, {{ $siswa->nama }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-lg sm:text-2xl text-green-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $absensi['hadir'] ?? 0 }}</p>
            <p class="text-gray-500 text-xs sm:text-sm">Hadir</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-envelope text-lg sm:text-2xl text-yellow-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $absensi['izin'] ?? 0 }}</p>
            <p class="text-gray-500 text-xs sm:text-sm">Izin</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-medkit text-lg sm:text-2xl text-blue-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $absensi['sakit'] ?? 0 }}</p>
            <p class="text-gray-500 text-xs sm:text-sm">Sakit</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-times text-lg sm:text-2xl text-red-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $absensi['alpha'] ?? 0 }}</p>
            <p class="text-gray-500 text-xs sm:text-sm">Alpha</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Jadwal Hari Ini -->
    <div class="xl:col-span-2 bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h2 class="font-semibold text-gray-800">Jadwal Hari Ini</h2>
        </div>
        <div class="p-6">
            @if($jadwalHariIni->count() > 0)
            <div class="space-y-4">
                @foreach($jadwalHariIni as $jadwal)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $jadwal->mataPelajaran->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $jadwal->guru->nama }} • {{ $jadwal->ruang->nama }}</p>
                        </div>
                    </div>
                    <p class="font-medium">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Tidak ada jadwal hari ini</p>
            @endif
        </div>
    </div>

    <!-- Tugas Aktif -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">Tugas Aktif</h2>
            <a href="{{ route('siswa.tugas.index') }}" class="text-indigo-600 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            @if($tugasAktif->count() > 0)
            <div class="space-y-3">
                @foreach($tugasAktif as $tugas)
                <a href="{{ route('siswa.tugas.show', $tugas) }}" class="block p-3 border rounded-lg hover:border-indigo-500">
                    <p class="font-medium text-sm">{{ Str::limit($tugas->judul, 30) }}</p>
                    <p class="text-xs text-gray-500">{{ $tugas->mataPelajaran->nama }}</p>
                    <p class="text-xs text-red-600 mt-1"><i class="fas fa-clock mr-1"></i>{{ $tugas->deadline->diffForHumans() }}</p>
                </a>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Tidak ada tugas aktif</p>
            @endif
        </div>
    </div>
</div>

<!-- Pengumuman -->
@if($pengumuman->count() > 0)
<div class="mt-6 bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="font-semibold text-gray-800">Pengumuman Terbaru</h2>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            @foreach($pengumuman as $p)
            <div class="border-l-4 border-indigo-500 pl-4">
                <p class="font-medium">{{ $p->judul }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($p->konten, 150) }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $p->dipublikasi_pada->format('d/m/Y') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
