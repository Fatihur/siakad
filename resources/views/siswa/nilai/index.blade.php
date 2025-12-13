@extends('layouts.siswa')
@section('title', 'Nilai')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Nilai Akademik</h1>
    <p class="text-gray-500">{{ $semester ? $semester->tahunAkademik->tahun . ' - ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6">
        @if($nilai->count() > 0)
        <div class="overflow-x-auto">
        <table class="w-full min-w-[700px]">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500 text-sm">
                    <th class="px-2 sm:px-4 py-3">No</th>
                    <th class="px-2 sm:px-4 py-3">Mata Pelajaran</th>
                    <th class="px-2 sm:px-4 py-3">Guru</th>
                    <th class="px-2 sm:px-4 py-3 text-center">UTS</th>
                    <th class="px-2 sm:px-4 py-3 text-center">Tugas</th>
                    <th class="px-2 sm:px-4 py-3 text-center">Sikap</th>
                    <th class="px-2 sm:px-4 py-3 text-center">Keterampilan</th>
                    <th class="px-2 sm:px-4 py-3 text-center">Raport</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilai as $i => $n)
                <tr class="border-t">
                    <td class="px-2 sm:px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-2 sm:px-4 py-3 font-medium text-sm">{{ $n->bukuNilai->mataPelajaran->nama }}</td>
                    <td class="px-2 sm:px-4 py-3 text-gray-500 text-sm">{{ $n->bukuNilai->guru->nama }}</td>
                    <td class="px-2 sm:px-4 py-3 text-center">{{ $n->nilai_uts ?? '-' }}</td>
                    <td class="px-2 sm:px-4 py-3 text-center">{{ $n->nilai_tugas ?? '-' }}</td>
                    <td class="px-2 sm:px-4 py-3 text-center">{{ $n->nilai_sikap ?? '-' }}</td>
                    <td class="px-2 sm:px-4 py-3 text-center">{{ $n->nilai_keterampilan ?? '-' }}</td>
                    <td class="px-2 sm:px-4 py-3 text-center font-bold text-indigo-600">{{ $n->nilai_raport ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Belum ada nilai yang terverifikasi</p>
        @endif
    </div>
</div>
@endsection
