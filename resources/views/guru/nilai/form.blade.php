@extends('layouts.guru')
@section('title', 'Input Nilai')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Input Nilai</h1>
    <p class="text-gray-500">{{ $bukuNilai->mataPelajaran->nama }} - {{ $bukuNilai->kelas->nama }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex justify-between items-center">
        <div>
            <span class="px-2 py-1 rounded-full text-xs {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'bg-green-100 text-green-800' : ($bukuNilai->status_verifikasi == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($bukuNilai->status_verifikasi) }}
            </span>
            @if($bukuNilai->catatan_verifikasi)
            <p class="text-sm text-red-600 mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $bukuNilai->catatan_verifikasi }}</p>
            @endif
        </div>
        @if(in_array($bukuNilai->status_verifikasi, ['draft', 'ditolak']))
        <form action="{{ route('guru.nilai.ajukan', $bukuNilai) }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                <i class="fas fa-paper-plane mr-1"></i>Ajukan Verifikasi
            </button>
        </form>
        @endif
    </div>
    
    <form action="{{ route('guru.nilai.update', $bukuNilai) }}" method="POST" class="p-6">
        @csrf @method('PUT')
        <div class="overflow-x-auto">
            <table class="w-full mb-6 min-w-[800px]">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-500 text-sm">
                        <th class="px-2 sm:px-4 py-3">No</th>
                        <th class="px-2 sm:px-4 py-3">NIS</th>
                        <th class="px-2 sm:px-4 py-3">Nama Siswa</th>
                        <th class="px-2 sm:px-4 py-3 text-center">UTS</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Tugas</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Sikap</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Keterampilan</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Raport</th>
                        <th class="px-2 sm:px-4 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukuNilai->itemNilai as $i => $item)
                    <tr class="border-t">
                        <td class="px-2 sm:px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm">{{ $item->siswa->nis }}</td>
                        <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm">{{ $item->siswa->nama }}</td>
                        <td class="px-2 sm:px-4 py-3"><input type="number" name="nilai[{{ $item->id }}][nilai_uts]" value="{{ $item->nilai_uts }}" min="0" max="100" step="0.01" class="w-14 sm:w-16 px-1 sm:px-2 py-1 border rounded text-center text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                        <td class="px-2 sm:px-4 py-3"><input type="number" name="nilai[{{ $item->id }}][nilai_tugas]" value="{{ $item->nilai_tugas }}" min="0" max="100" step="0.01" class="w-14 sm:w-16 px-1 sm:px-2 py-1 border rounded text-center text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                        <td class="px-2 sm:px-4 py-3"><input type="number" name="nilai[{{ $item->id }}][nilai_sikap]" value="{{ $item->nilai_sikap }}" min="0" max="100" step="0.01" class="w-14 sm:w-16 px-1 sm:px-2 py-1 border rounded text-center text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                        <td class="px-2 sm:px-4 py-3"><input type="number" name="nilai[{{ $item->id }}][nilai_keterampilan]" value="{{ $item->nilai_keterampilan }}" min="0" max="100" step="0.01" class="w-14 sm:w-16 px-1 sm:px-2 py-1 border rounded text-center text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                        <td class="px-2 sm:px-4 py-3"><input type="number" name="nilai[{{ $item->id }}][nilai_raport]" value="{{ $item->nilai_raport }}" min="0" max="100" step="0.01" class="w-14 sm:w-16 px-1 sm:px-2 py-1 border rounded text-center font-bold text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                        <td class="px-2 sm:px-4 py-3"><input type="text" name="nilai[{{ $item->id }}][catatan]" value="{{ $item->catatan }}" class="w-24 sm:w-32 px-1 sm:px-2 py-1 border rounded text-xs sm:text-sm" {{ $bukuNilai->status_verifikasi == 'terverifikasi' ? 'disabled' : '' }}></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($bukuNilai->status_verifikasi != 'terverifikasi')
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-center">
                <i class="fas fa-save mr-2"></i>Simpan Nilai
            </button>
            <a href="{{ route('guru.nilai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-center">Kembali</a>
        </div>
        @else
        <a href="{{ route('guru.nilai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 inline-block">Kembali</a>
        @endif
    </form>
</div>
@endsection
