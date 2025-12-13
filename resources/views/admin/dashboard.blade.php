@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500">Selamat datang di SIAKAD</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user-tie text-lg sm:text-2xl text-blue-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_guru'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Total Guru</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user-graduate text-lg sm:text-2xl text-yellow-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Total Siswa</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-chalkboard text-lg sm:text-2xl text-red-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_kelas'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Total Kelas</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-14 sm:h-14 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-calendar-check text-lg sm:text-2xl text-green-600"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['jadwal_aktif'] }}</p>
            <p class="text-gray-500 text-xs sm:text-sm truncate">Jadwal Aktif</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Nilai Pending -->
    <div class="xl:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">Nilai Menunggu Verifikasi</h2>
            <a href="{{ route('admin.verifikasi-nilai.index') }}" class="text-indigo-600 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            @if($nilaiPending->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="pb-3">Kelas</th>
                            <th class="pb-3">Mata Pelajaran</th>
                            <th class="pb-3">Guru</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilaiPending as $nilai)
                        <tr class="border-t">
                            <td class="py-3">{{ $nilai->kelas->nama }}</td>
                            <td class="py-3">{{ $nilai->mataPelajaran->nama }}</td>
                            <td class="py-3">{{ $nilai->guru->nama }}</td>
                            <td class="py-3">
                                <a href="{{ route('admin.verifikasi-nilai.show', $nilai) }}" class="text-indigo-600 hover:underline text-sm">Review</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada nilai yang menunggu verifikasi</p>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h2 class="font-semibold text-gray-800">Status Verifikasi</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Menunggu Verifikasi</span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">{{ $stats['nilai_pending'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Terverifikasi</span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">{{ $stats['nilai_terverifikasi'] }}</span>
                </div>
            </div>
            @if($semester)
            <div class="mt-6 pt-6 border-t">
                <p class="text-sm text-gray-500">Semester Aktif</p>
                <p class="font-semibold text-gray-800">{{ $semester->tahunAkademik->tahun }} - {{ ucfirst($semester->tipe) }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
