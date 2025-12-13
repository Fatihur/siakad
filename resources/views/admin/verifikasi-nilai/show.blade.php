@extends('layouts.admin')
@section('title', 'Detail Verifikasi Nilai')

@section('content')
<div class="bg-white rounded-xl shadow-sm mb-6">
    <div class="p-6 border-b">
        <h2 class="font-semibold text-gray-800">Detail Nilai</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="font-medium">{{ $bukuNilai->kelas->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Mata Pelajaran</p>
                <p class="font-medium">{{ $bukuNilai->mataPelajaran->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Guru</p>
                <p class="font-medium">{{ $bukuNilai->guru->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-2 py-1 rounded-full text-xs {{ $bukuNilai->status_verifikasi == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : ($bukuNilai->status_verifikasi == 'terverifikasi' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($bukuNilai->status_verifikasi) }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full mb-6 min-w-[600px]">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500 text-sm">
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3 text-center">UTS</th>
                    <th class="px-4 py-3 text-center">Tugas</th>
                    <th class="px-4 py-3 text-center">Sikap</th>
                    <th class="px-4 py-3 text-center">Keterampilan</th>
                    <th class="px-4 py-3 text-center">Raport</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bukuNilai->itemNilai as $i => $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">{{ $item->siswa->nama }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->nilai_uts ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->nilai_tugas ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->nilai_sikap ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->nilai_keterampilan ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-bold">{{ $item->nilai_raport ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        @if($bukuNilai->status_verifikasi == 'diajukan')
        <form action="{{ route('admin.verifikasi-nilai.verifikasi', $bukuNilai) }}" method="POST" class="border-t pt-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="catatan" rows="2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" name="status" value="terverifikasi" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 text-center">
                    <i class="fas fa-check mr-2"></i>Verifikasi
                </button>
                <button type="submit" name="status" value="ditolak" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 text-center">
                    <i class="fas fa-times mr-2"></i>Tolak
                </button>
                <a href="{{ route('admin.verifikasi-nilai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-center">Kembali</a>
            </div>
        </form>
        @else
        <div class="border-t pt-6">
            <a href="{{ route('admin.verifikasi-nilai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 inline-block">Kembali</a>
        </div>
        @endif
    </div>
</div>
@endsection
