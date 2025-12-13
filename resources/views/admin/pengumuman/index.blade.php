@extends('layouts.admin')
@section('title', 'Pengumuman')

@section('content')
<x-table title="Data Pengumuman" :createRoute="route('admin.pengumuman.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Judul</th>
            <th class="px-4 py-3">Lingkup</th>
            <th class="px-4 py-3">Target</th>
            <th class="px-4 py-3">Dipublikasi</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ Str::limit($item->judul, 40) }}</td>
        <td class="px-4 py-3"><span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs capitalize">{{ $item->lingkup }}</span></td>
        <td class="px-4 py-3">
            @if($item->lingkup == 'kelas') {{ $item->kelas?->nama }}
            @elseif($item->lingkup == 'jurusan') {{ $item->jurusan?->nama }}
            @else Semua @endif
        </td>
        <td class="px-4 py-3">{{ $item->dipublikasi_pada?->format('d/m/Y H:i') }}</td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.pengumuman.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
