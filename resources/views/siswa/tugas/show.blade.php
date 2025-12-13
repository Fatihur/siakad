@extends('layouts.siswa')
@section('title', 'Detail Tugas')

@section('content')
<div class="mb-6">
    <a href="{{ route('siswa.tugas.index') }}" class="text-indigo-600 hover:underline text-sm"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $tugas->judul }}</h1>
    <p class="text-gray-500">{{ $tugas->mataPelajaran->nama }} • {{ $tugas->guru->nama }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="font-semibold mb-4">Deskripsi Tugas</h2>
            <p class="text-gray-600 mb-4">{{ $tugas->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <div class="flex gap-4 text-sm text-gray-500">
                <span><i class="fas fa-calendar mr-1"></i>Deadline: {{ $tugas->deadline->format('d/m/Y H:i') }}</span>
                <span class="{{ $tugas->deadline < now() ? 'text-red-600' : 'text-green-600' }}">
                    {{ $tugas->deadline->diffForHumans() }}
                </span>
            </div>
            @if($tugas->lampiran)
            <div class="mt-4">
                <a href="{{ Storage::url($tugas->lampiran) }}" target="_blank" class="text-indigo-600 hover:underline">
                    <i class="fas fa-paperclip mr-1"></i>Download Lampiran
                </a>
            </div>
            @endif
        </div>

        <!-- Form Pengumpulan -->
        @if(!$tugas->ditutup)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold mb-4">{{ $pengumpulan ? 'Update Pengumpulan' : 'Kumpulkan Tugas' }}</h2>
            <form action="{{ route('siswa.tugas.kumpulkan', $tugas) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($tugas->jenis_pengumpulan == 'file')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
                    <input type="file" name="file" {{ $pengumpulan ? '' : 'required' }} class="w-full px-4 py-2 border rounded-lg">
                    @if($pengumpulan && $pengumpulan->file_path)
                    <p class="text-sm text-gray-500 mt-1">File sebelumnya: {{ basename($pengumpulan->file_path) }}</p>
                    @endif
                </div>
                @elseif($tugas->jenis_pengumpulan == 'link')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Link</label>
                    <input type="url" name="url_link" value="{{ $pengumpulan->url_link ?? '' }}" required placeholder="https://..."
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                @else
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                    <textarea name="konten" rows="5" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $pengumpulan->konten ?? '' }}</textarea>
                </div>
                @endif
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-paper-plane mr-2"></i>{{ $pengumpulan ? 'Update' : 'Kumpulkan' }}
                </button>
            </form>
        </div>
        @else
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
            <i class="fas fa-lock text-red-500 text-2xl mb-2"></i>
            <p class="text-red-600">Tugas sudah ditutup</p>
        </div>
        @endif
    </div>

    <!-- Status Pengumpulan -->
    <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
        <h2 class="font-semibold mb-4">Status Pengumpulan</h2>
        @if($pengumpulan)
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">Status</span>
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Sudah Dikumpulkan</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Waktu</span>
                <span>{{ $pengumpulan->dikumpulkan_pada->format('d/m/Y H:i') }}</span>
            </div>
            @if($pengumpulan->terlambat)
            <div class="flex justify-between">
                <span class="text-gray-500">Keterangan</span>
                <span class="text-red-600">Terlambat</span>
            </div>
            @endif
            @if($pengumpulan->nilai !== null)
            <div class="border-t pt-3 mt-3">
                <p class="text-gray-500 text-sm">Nilai</p>
                <p class="text-3xl font-bold text-green-600">{{ $pengumpulan->nilai }}</p>
                @if($pengumpulan->feedback)
                <p class="text-sm text-gray-600 mt-2">{{ $pengumpulan->feedback }}</p>
                @endif
            </div>
            @else
            <p class="text-yellow-600 text-sm mt-3"><i class="fas fa-clock mr-1"></i>Menunggu penilaian</p>
            @endif
        </div>
        @else
        <p class="text-gray-500">Belum mengumpulkan tugas</p>
        @endif
    </div>
</div>
@endsection
