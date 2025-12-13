@extends('layouts.guru')
@section('title', 'Input Absensi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Input Absensi</h1>
    <p class="text-gray-500">{{ $jadwal->mataPelajaran->nama }} - {{ $jadwal->kelas->nama }} | Pertemuan ke-{{ $sesi->pertemuan_ke }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex justify-between items-center">
        <div>
            <p class="font-medium">Tanggal: {{ $sesi->tanggal->format('d F Y') }}</p>
            <p class="text-sm text-gray-500">Status: {{ ucfirst($sesi->status) }}</p>
        </div>
        @if($sesi->status == 'dibuka')
        <form action="{{ route('guru.absensi.tutup', $sesi) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700" onclick="return confirm('Tutup sesi absensi?')">
                <i class="fas fa-lock mr-1"></i>Tutup Sesi
            </button>
        </form>
        @endif
    </div>
    
    <form action="{{ route('guru.absensi.store', $sesi) }}" method="POST" class="p-6">
        @csrf
        <div class="overflow-x-auto">
        <table class="w-full mb-6 min-w-[600px]">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500 text-sm">
                    <th class="px-2 sm:px-4 py-3">No</th>
                    <th class="px-2 sm:px-4 py-3">NIS</th>
                    <th class="px-2 sm:px-4 py-3">Nama Siswa</th>
                    <th class="px-2 sm:px-4 py-3">Status</th>
                    <th class="px-2 sm:px-4 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $i => $s)
                <tr class="border-t">
                    <td class="px-2 sm:px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm">{{ $s->nis }}</td>
                    <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm">{{ $s->nama }}</td>
                    <td class="px-2 sm:px-4 py-3">
                        <select name="absensi[{{ $s->id }}]" class="px-2 sm:px-3 py-2 border rounded-lg text-xs sm:text-sm" {{ $sesi->status == 'ditutup' ? 'disabled' : '' }}>
                            @foreach(['hadir', 'izin', 'sakit', 'alpha', 'terlambat'] as $status)
                            <option value="{{ $status }}" {{ ($absensi[$s->id] ?? 'hadir') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-2 sm:px-4 py-3">
                        <input type="text" name="catatan[{{ $s->id }}]" class="px-2 sm:px-3 py-2 border rounded-lg text-xs sm:text-sm w-full" placeholder="Catatan..." {{ $sesi->status == 'ditutup' ? 'disabled' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
        @if($sesi->status == 'dibuka')
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-center">
                <i class="fas fa-save mr-2"></i>Simpan Absensi
            </button>
            <a href="{{ route('guru.absensi.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-center">Kembali</a>
        </div>
        @else
        <a href="{{ route('guru.absensi.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 inline-block">Kembali</a>
        @endif
    </form>
</div>
@endsection
