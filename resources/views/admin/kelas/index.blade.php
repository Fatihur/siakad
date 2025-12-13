@extends('layouts.admin')
@section('title', 'Kelas')

@section('content')
<x-table title="Data Kelas" :createRoute="route('admin.kelas.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Tingkat</th>
            <th class="px-4 py-3">Jurusan</th>
            <th class="px-4 py-3">Rombel</th>
            <th class="px-4 py-3">Kapasitas</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->nama }}</td>
        <td class="px-4 py-3">{{ $item->tingkat }}</td>
        <td class="px-4 py-3">{{ $item->jurusan->nama }}</td>
        <td class="px-4 py-3">{{ $item->rombel ?? '-' }}</td>
        <td class="px-4 py-3">{{ $item->kapasitas }}</td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.kelas.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.kelas.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
