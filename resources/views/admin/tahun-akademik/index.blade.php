@extends('layouts.admin')
@section('title', 'Tahun Akademik')

@section('content')
<x-table title="Data Tahun Akademik" :createRoute="route('admin.tahun-akademik.create')">
    <x-slot:header>
        <tr class="text-left text-gray-500 text-sm">
            <th class="px-4 py-3">Tahun</th>
            <th class="px-4 py-3">Semester</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">{{ $item->tahun }}</td>
        <td class="px-4 py-3">
            @foreach($item->semester as $sem)
            <div class="flex items-center gap-2 mb-1">
                <span class="capitalize">{{ $sem->tipe }}</span>
                @if($sem->aktif)
                <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                @else
                <form action="{{ route('admin.semester.set-aktif', $sem) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-indigo-600 hover:underline">Set Aktif</button>
                </form>
                @endif
            </div>
            @endforeach
        </td>
        <td class="px-4 py-3">
            @if($item->aktif)
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
            @else
            <form action="{{ route('admin.tahun-akademik.set-aktif', $item) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs hover:bg-indigo-100">Set Aktif</button>
            </form>
            @endif
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <a href="{{ route('admin.tahun-akademik.edit', $item) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.tahun-akademik.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
