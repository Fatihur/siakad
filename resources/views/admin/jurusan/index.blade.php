@extends('layouts.admin')
@section('title', 'Jurusan')

@section('content')
<x-table title="Data Jurusan" :createRoute="route('admin.jurusan.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Kode</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Deskripsi</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->kode }}</td>
        <td class="px-4 py-3">{{ $item->nama }}</td>
        <td class="px-4 py-3 text-gray-500">{{ Str::limit($item->deskripsi, 50) }}</td>
        <td class="px-4 py-3">
            <span class="px-2 py-1 rounded-full text-xs {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.jurusan.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.jurusan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
