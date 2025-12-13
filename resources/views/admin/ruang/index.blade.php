@extends('layouts.admin')
@section('title', 'Ruang')

@section('content')
<x-table title="Data Ruang" :createRoute="route('admin.ruang.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Kode</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Tipe</th>
            <th class="px-4 py-3">Kapasitas</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->kode }}</td>
        <td class="px-4 py-3">{{ $item->nama }}</td>
        <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs capitalize">{{ $item->tipe }}</span></td>
        <td class="px-4 py-3">{{ $item->kapasitas }}</td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.ruang.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.ruang.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
