@extends('layouts.guru')
@section('title', 'Materi')

@section('content')
<x-table title="Materi Pembelajaran" :createRoute="route('guru.materi.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Judul</th>
            <th class="px-4 py-3">Kelas</th>
            <th class="px-4 py-3">Mata Pelajaran</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ Str::limit($item->judul, 40) }}</td>
        <td class="px-4 py-3">{{ $item->kelas->nama }}</td>
        <td class="px-4 py-3">{{ $item->mataPelajaran->nama }}</td>
        <td class="px-4 py-3">
            <span class="px-2 py-1 rounded-full text-xs {{ $item->visibilitas == 'publik' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($item->visibilitas) }}
            </span>
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('guru.materi.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('guru.materi.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
