@extends('layouts.guru')
@section('title', 'Tugas')

@section('content')
<x-table title="Daftar Tugas" :createRoute="route('guru.tugas.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Judul</th>
            <th class="px-4 py-3">Kelas</th>
            <th class="px-4 py-3">Deadline</th>
            <th class="px-4 py-3">Pengumpulan</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ Str::limit($item->judul, 30) }}</td>
        <td class="px-4 py-3">{{ $item->kelas->nama }}</td>
        <td class="px-4 py-3">
            <span class="{{ $item->deadline < now() ? 'text-red-600' : '' }}">{{ $item->deadline->format('d/m/Y H:i') }}</span>
        </td>
        <td class="px-4 py-3">
            <span class="text-green-600">{{ $item->pengumpulan_count }}</span>
            @if($item->belum_dinilai_count > 0)
            <span class="text-yellow-600 ml-2">({{ $item->belum_dinilai_count }} belum dinilai)</span>
            @endif
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('guru.tugas.show', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-eye"></i></a>
                <a href="{{ route('guru.tugas.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('guru.tugas.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
