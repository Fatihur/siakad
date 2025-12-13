@extends('layouts.guru')
@section('title', 'Nilai')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengelolaan Nilai</h1>
    <p class="text-gray-500">Input dan kelola nilai siswa</p>
</div>

@if($bukuNilai->count() > 0)
<div class="bg-white rounded-xl shadow-sm mb-6">
    <div class="p-6 border-b">
        <h2 class="font-semibold">Buku Nilai Aktif</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500 text-sm">
                    <th class="px-6 py-3">Kelas</th>
                    <th class="px-6 py-3">Mata Pelajaran</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bukuNilai as $buku)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $buku->kelas->nama }}</td>
                    <td class="px-6 py-4">{{ $buku->mataPelajaran->nama }}</td>
                    <td class="px-6 py-4">
                        @php
                            $colors = ['draft' => 'bg-gray-100 text-gray-800', 'diajukan' => 'bg-yellow-100 text-yellow-800', 'terverifikasi' => 'bg-green-100 text-green-800', 'ditolak' => 'bg-red-100 text-red-800'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $colors[$buku->status_verifikasi] }}">{{ ucfirst($buku->status_verifikasi) }}</span>
                        @if($buku->catatan_verifikasi)
                        <p class="text-xs text-red-600 mt-1">{{ $buku->catatan_verifikasi }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('guru.nilai.edit', $buku) }}" class="text-indigo-600 hover:underline">
                            <i class="fas fa-edit mr-1"></i>Edit Nilai
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($jadwalTanpaBuku->count() > 0)
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="font-semibold">Buat Buku Nilai Baru</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($jadwalTanpaBuku as $j)
            <form action="{{ route('guru.nilai.create') }}" method="POST" class="border rounded-lg p-4 hover:border-indigo-500 transition">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $j->kelas_id }}">
                <input type="hidden" name="mata_pelajaran_id" value="{{ $j->mata_pelajaran_id }}">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $j->mataPelajaran->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $j->kelas->nama }}</p>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700">
                    <i class="fas fa-plus mr-1"></i>Buat Buku Nilai
                </button>
            </form>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
