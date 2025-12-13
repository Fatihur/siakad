@extends('layouts.admin')
@section('title', 'Siswa')

@section('content')
<x-table title="Data Siswa" :createRoute="route('admin.siswa.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">NIS</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Kelas</th>
            <th class="px-4 py-3">JK</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->nis }}</td>
        <td class="px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold text-sm">
                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                </div>
                {{ $item->nama }}
            </div>
        </td>
        <td class="px-4 py-3">{{ $item->kelas ? $item->kelas->nama : '-' }}</td>
        <td class="px-4 py-3">{{ $item->jenis_kelamin }}</td>
        <td class="px-4 py-3">
            <span class="px-2 py-1 rounded-full text-xs {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.siswa.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.siswa.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
