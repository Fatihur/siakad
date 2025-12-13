@extends('layouts.siswa')
@section('title', 'Materi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Materi Pembelajaran</h1>
    <p class="text-gray-500">{{ $semester ? $semester->tahunAkademik->tahun . ' - ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6">
        @if($materi->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($materi as $m)
            <div class="border rounded-lg p-4 hover:border-indigo-500 transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ Str::limit($m->judul, 25) }}</p>
                        <p class="text-xs text-gray-500">{{ $m->mataPelajaran->nama }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($m->deskripsi, 80) }}</p>
                <div class="flex gap-2">
                    @if($m->file_path)
                    <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="flex-1 bg-indigo-600 text-white text-center py-2 rounded-lg text-sm hover:bg-indigo-700">
                        <i class="fas fa-download mr-1"></i>Download
                    </a>
                    @endif
                    @if($m->url_link)
                    <a href="{{ $m->url_link }}" target="_blank" class="flex-1 border text-center py-2 rounded-lg text-sm hover:bg-gray-50">
                        <i class="fas fa-external-link-alt mr-1"></i>Buka Link
                    </a>
                    @endif
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $m->guru->nama }} • {{ $m->created_at->format('d/m/Y') }}</p>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $materi->links() }}</div>
        @else
        <p class="text-gray-500 text-center py-8">Belum ada materi</p>
        @endif
    </div>
</div>
@endsection
