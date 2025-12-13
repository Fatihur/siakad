@extends('layouts.admin')
@section('title', 'Verifikasi Nilai')

@section('content')
<x-table title="Verifikasi Nilai">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Kelas</th>
            <th class="px-4 py-3">Mata Pelajaran</th>
            <th class="px-4 py-3">Guru</th>
            <th class="px-4 py-3">Semester</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->kelas->nama }}</td>
        <td class="px-4 py-3">{{ $item->mataPelajaran->nama }}</td>
        <td class="px-4 py-3">{{ $item->guru->nama }}</td>
        <td class="px-4 py-3">{{ $item->semester->tahunAkademik->tahun }} - {{ ucfirst($item->semester->tipe) }}</td>
        <td class="px-4 py-3">
            @php
                $statusColors = [
                    'diajukan' => 'bg-yellow-100 text-yellow-800',
                    'terverifikasi' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                ];
            @endphp
            <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$item->status_verifikasi] ?? 'bg-gray-100' }}">
                {{ ucfirst($item->status_verifikasi) }}
            </span>
        </td>
        <td class="px-4 py-3">
            <a href="{{ route('admin.verifikasi-nilai.show', $item) }}" class="text-indigo-600 hover:underline">
                <i class="fas fa-eye mr-1"></i>Review
            </a>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
