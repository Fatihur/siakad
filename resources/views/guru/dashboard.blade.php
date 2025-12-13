@extends('layouts.guru')
@section('title', 'Dashboard Guru')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500">Selamat datang, {{ $guru->nama }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-chalkboard text-lg sm:text-2xl text-blue-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_kelas'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Kelas Diajar</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-tasks text-lg sm:text-2xl text-yellow-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['tugas_belum_dinilai'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Belum Dinilai</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-file-alt text-lg sm:text-2xl text-orange-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['nilai_draft'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Nilai Draft</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-exclamation-circle text-lg sm:text-2xl text-red-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['nilai_ditolak'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Nilai Ditolak</p>
        </div>
    </div>
</div>

<!-- Jadwal Hari Ini -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="font-semibold text-gray-800">Jadwal Mengajar Hari Ini</h2>
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
                        <p class="text-sm text-gray-500">{{ $jadwal->kelas->nama }} • {{ $jadwal->ruang->nama }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-medium">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                    <a href="{{ route('guru.absensi.create', $jadwal) }}" class="text-sm text-indigo-600 hover:underline">Mulai Absensi</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-4">Tidak ada jadwal mengajar hari ini</p>
        @endif
    </div>
</div>
@endsection
