@extends('layouts.admin')
@section('title', 'Siswa')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Data Siswa</h2>
    <p class="text-[#64748B]">Kelola data siswa</p>
</div>

<x-table title="Daftar Siswa" :createRoute="route('admin.siswa.create')">
    <x-slot:header>
        <tr>
            <th class="px-6 py-4 text-left">NIS</th>
            <th class="px-6 py-4 text-left">Nama Siswa</th>
            <th class="px-6 py-4 text-left">Kelas</th>
            <th class="px-6 py-4 text-left">JK</th>
            <th class="px-6 py-4 text-left">Status</th>
            <th class="px-6 py-4 text-left">Aksi</th>
        </tr>
    </x-slot:header>
    @foreach($data as $item)
    <tr>
        <td class="px-6 py-4">
            <span class="font-mono text-sm text-[#64748B]">{{ $item->nis }}</span>
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-meta-6 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                </div>
                <span class="font-medium text-[#1C2434]">{{ $item->nama }}</span>
            </div>
        </td>
        <td class="px-6 py-4 text-[#64748B]">{{ $item->kelas ? $item->kelas->nama : '-' }}</td>
        <td class="px-6 py-4 text-[#64748B]">{{ $item->jenis_kelamin }}</td>
        <td class="px-6 py-4">
            <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-danger' }}">
                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.siswa.edit', $item) }}" class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.siswa.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data siswa ini?')">
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
