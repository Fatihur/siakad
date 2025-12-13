@extends('layouts.guru')
@section('title', 'Absensi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Absensi Siswa</h1>
    <p class="text-gray-500">Pilih jadwal untuk melakukan absensi</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6">
        @if($jadwal->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($jadwal as $j)
            <div class="border rounded-lg p-4 hover:border-indigo-500 transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $j->mataPelajaran->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $j->kelas->nama }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500 mb-3">
                    <p><i class="fas fa-calendar mr-2"></i>{{ ucfirst($j->hari) }}</p>
                    <p><i class="fas fa-clock mr-2"></i>{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('guru.absensi.create', $j) }}" class="flex-1 bg-indigo-600 text-white text-center py-2 rounded-lg text-sm hover:bg-indigo-700">
                        <i class="fas fa-clipboard-check mr-1"></i>Absensi
                    </a>
                    <a href="{{ route('guru.absensi.riwayat', $j) }}" class="px-3 py-2 border rounded-lg text-sm hover:bg-gray-50">
                        <i class="fas fa-history"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Tidak ada jadwal mengajar</p>
        @endif
    </div>
</div>
@endsection
