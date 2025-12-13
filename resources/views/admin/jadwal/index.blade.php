@extends('layouts.admin')
@section('title', 'Jadwal')

@section('content')
<div class="mb-4 flex flex-wrap gap-2">
    <a href="{{ route('admin.jadwal.generator') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-flex items-center">
        <i class="fas fa-magic mr-2"></i>Generator Jadwal
    </a>
</div>

<x-table title="Data Jadwal" :createRoute="route('admin.jadwal.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Hari</th>
            <th class="px-4 py-3">Jam</th>
            <th class="px-4 py-3">Kelas</th>
            <th class="px-4 py-3">Mata Pelajaran</th>
            <th class="px-4 py-3">Guru</th>
            <th class="px-4 py-3">Ruang</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium capitalize">{{ $item->hari }}</td>
        <td class="px-4 py-3">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</td>
        <td class="px-4 py-3">{{ $item->kelas->nama }}</td>
        <td class="px-4 py-3">{{ $item->mataPelajaran->nama }}</td>
        <td class="px-4 py-3">{{ $item->guru->nama }}</td>
        <td class="px-4 py-3">{{ $item->ruang->nama }}</td>
        <td class="px-4 py-3">
            <form action="{{ route('admin.jadwal.publish', $item) }}" method="POST">
                @csrf
                <button type="submit" class="px-2 py-1 rounded-full text-xs {{ $item->dipublikasi ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                    {{ $item->dipublikasi ? 'Publik' : 'Draft' }}
                </button>
            </form>
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.jadwal.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
