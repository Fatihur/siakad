@extends('layouts.guru')
@section('title', 'Detail Tugas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">{{ $tugas->judul }}</h1>
    <p class="text-gray-500">{{ $tugas->kelas->nama }} - {{ $tugas->mataPelajaran->nama }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h2 class="font-semibold mb-4">Deskripsi Tugas</h2>
        <p class="text-gray-600 mb-4">{{ $tugas->deskripsi ?? 'Tidak ada deskripsi' }}</p>
        <div class="flex gap-4 text-sm text-gray-500">
            <span><i class="fas fa-calendar mr-1"></i>Deadline: {{ $tugas->deadline->format('d/m/Y H:i') }}</span>
            <span><i class="fas fa-upload mr-1"></i>Jenis: {{ ucfirst($tugas->jenis_pengumpulan) }}</span>
        </div>
        @if($tugas->lampiran)
        <div class="mt-4">
            <a href="{{ Storage::url($tugas->lampiran) }}" target="_blank" class="text-indigo-600 hover:underline">
                <i class="fas fa-paperclip mr-1"></i>Download Lampiran
            </a>
        </div>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h2 class="font-semibold mb-4">Statistik</h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">Total Pengumpulan</span>
                <span class="font-medium">{{ $tugas->pengumpulan->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Sudah Dinilai</span>
                <span class="font-medium text-green-600">{{ $tugas->pengumpulan->whereNotNull('nilai')->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Belum Dinilai</span>
                <span class="font-medium text-yellow-600">{{ $tugas->pengumpulan->whereNull('nilai')->count() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="font-semibold">Daftar Pengumpulan</h2>
    </div>
    <div class="p-6">
        @if($tugas->pengumpulan->count() > 0)
        <div class="space-y-4">
            @foreach($tugas->pengumpulan as $p)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-medium">{{ $p->siswa->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $p->siswa->nis }} • Dikumpulkan: {{ $p->dikumpulkan_pada->format('d/m/Y H:i') }}</p>
                        @if($p->terlambat)
                        <span class="text-xs text-red-600"><i class="fas fa-clock mr-1"></i>Terlambat</span>
                        @endif
                    </div>
                    <div class="text-right">
                        @if($p->nilai !== null)
                        <span class="text-2xl font-bold text-green-600">{{ $p->nilai }}</span>
                        @else
                        <span class="text-gray-400">Belum dinilai</span>
                        @endif
                    </div>
                </div>
                
                @if($p->konten)
                <div class="bg-gray-50 p-3 rounded mb-3 text-sm">{{ Str::limit($p->konten, 200) }}</div>
                @endif
                
                @if($p->file_path)
                <a href="{{ Storage::url($p->file_path) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">
                    <i class="fas fa-download mr-1"></i>Download File
                </a>
                @endif
                
                @if($p->url_link)
                <a href="{{ $p->url_link }}" target="_blank" class="text-indigo-600 hover:underline text-sm">
                    <i class="fas fa-external-link-alt mr-1"></i>Buka Link
                </a>
                @endif
                
                <form action="{{ route('guru.tugas.nilai-pengumpulan', $p) }}" method="POST" class="mt-4 pt-4 border-t flex flex-col sm:flex-row gap-3 sm:items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm text-gray-500 mb-1">Nilai</label>
                        <input type="number" name="nilai" value="{{ $p->nilai }}" min="0" max="100" required class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm text-gray-500 mb-1">Feedback</label>
                        <input type="text" name="feedback" value="{{ $p->feedback }}" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-4">Belum ada pengumpulan</p>
        @endif
    </div>
</div>
@endsection
