@extends('layouts.admin')
@section('title', 'Mata Pelajaran')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Mata Pelajaran</h2>
    <p class="text-[#64748B]">Kelola data mata pelajaran</p>
</div>

<x-table title="Daftar Mata Pelajaran" :createRoute="route('admin.mata-pelajaran.create')">
    <x-slot:header>
        <tr>
            <th class="px-6 py-4 text-left">Kode</th>
            <th class="px-6 py-4 text-left">Nama</th>
            <th class="px-6 py-4 text-left">Kelompok</th>
            <th class="px-6 py-4 text-left">Jam/Minggu</th>
            <th class="px-6 py-4 text-left">Guru Pengajar</th>
            <th class="px-6 py-4 text-left">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr>
        <td class="px-6 py-4">
            <span class="font-mono text-sm font-medium text-[#1C2434]">{{ $item->kode }}</span>
        </td>
        <td class="px-6 py-4">
            <span class="font-medium text-[#1C2434]">{{ $item->nama }}</span>
        </td>
        <td class="px-6 py-4">
            @php
                $kelompokColors = [
                    'wajib' => 'badge-primary',
                    'peminatan' => 'badge-info',
                    'muatan_lokal' => 'badge-warning',
                ];
            @endphp
            <span class="badge {{ $kelompokColors[$item->kelompok] ?? 'badge-primary' }} capitalize">
                {{ str_replace('_', ' ', $item->kelompok) }}
            </span>
        </td>
        <td class="px-6 py-4 text-[#64748B]">{{ $item->jam_per_minggu }} jam</td>
        <td class="px-6 py-4">
            @if($item->guru->count() > 0)
                <div class="flex flex-wrap gap-1">
                    @foreach($item->guru->take(3) as $g)
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-[#EFF4FB] text-[#1C2434] rounded text-xs">
                        <span class="w-5 h-5 bg-primary rounded flex items-center justify-center text-white text-[10px] font-semibold">
                            {{ strtoupper(substr($g->nama, 0, 1)) }}
                        </span>
                        {{ Str::limit($g->nama, 15) }}
                    </span>
                    @endforeach
                    @if($item->guru->count() > 3)
                    <span class="inline-flex items-center px-2 py-1 bg-[#F9FAFB] text-[#64748B] rounded text-xs">
                        +{{ $item->guru->count() - 3 }} lainnya
                    </span>
                    @endif
                </div>
            @else
                <span class="text-[#9CA3AF] text-sm">Belum ada guru</span>
            @endif
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.mata-pelajaran.edit', $item) }}" class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.mata-pelajaran.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus mata pelajaran ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-[#64748B] hover:text-meta-1 hover:bg-[#FEF2F2] rounded-lg transition-colors" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</x-table>
@endsection
