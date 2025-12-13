@extends('layouts.admin')
@section('title', 'Mata Pelajaran')

@section('content')
<x-table title="Data Mata Pelajaran" :createRoute="route('admin.mata-pelajaran.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Kode</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Kelompok</th>
            <th class="px-4 py-3">Jam/Minggu</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->kode }}</td>
        <td class="px-4 py-3">{{ $item->nama }}</td>
        <td class="px-4 py-3"><span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs capitalize">{{ str_replace('_', ' ', $item->kelompok) }}</span></td>
        <td class="px-4 py-3">{{ $item->jam_per_minggu }}</td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.mata-pelajaran.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.mata-pelajaran.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
