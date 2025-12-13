@extends('layouts.siswa')
@section('title', 'Tugas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Tugas</h1>
    <p class="text-gray-500">{{ $semester ? $semester->tahunAkademik->tahun . ' - ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6">
        @if($tugas->count() > 0)
        <div class="space-y-4">
            @foreach($tugas as $t)
            <a href="{{ route('siswa.tugas.show', $t) }}" class="block border rounded-lg p-4 hover:border-indigo-500 transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">{{ $t->judul }}</p>
                        <p class="text-sm text-gray-500">{{ $t->mataPelajaran->nama }} • {{ $t->guru->nama }}</p>
                    </div>
                    <div class="text-right">
                        @if($t->sudah_dikumpulkan > 0)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Sudah Dikumpulkan</span>
                        @else
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Belum Dikumpulkan</span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-4 mt-3 text-sm text-gray-500">
                    <span><i class="fas fa-calendar mr-1"></i>Deadline: {{ $t->deadline->format('d/m/Y H:i') }}</span>
                    <span class="{{ $t->deadline < now() ? 'text-red-600' : '' }}">
                        <i class="fas fa-clock mr-1"></i>{{ $t->deadline->diffForHumans() }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $tugas->links() }}</div>
        @else
        <p class="text-gray-500 text-center py-8">Tidak ada tugas</p>
        @endif
    </div>
</div>
@endsection
