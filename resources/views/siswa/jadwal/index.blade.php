@extends('layouts.siswa')
@section('title', 'Jadwal')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
    <p class="text-gray-500">{{ $semester ? $semester->tahunAkademik->tahun . ' - ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6">
        @if(count($jadwal) > 0)
        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
            @if(isset($jadwal[$hari]))
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-3 capitalize">{{ $hari }}</h3>
                <div class="space-y-2">
                    @foreach($jadwal[$hari] as $j)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ $j->mataPelajaran->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $j->guru->nama }} • {{ $j->ruang->nama }}</p>
                            </div>
                        </div>
                        <p class="font-medium text-indigo-600">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
        @else
        <p class="text-gray-500 text-center py-8">Tidak ada jadwal</p>
        @endif
    </div>
</div>
@endsection
