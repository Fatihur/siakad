@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Ruang' : 'Tambah Ruang')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Ruang' : 'Tambah Ruang'"
    :action="isset($data) ? route('admin.ruang.update', $data) : route('admin.ruang.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.ruang.index')">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Ruang</label>
            <input type="text" name="kode" value="{{ old('kode', $data->kode ?? '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruang</label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
            <select name="tipe" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach(['teori', 'lab', 'praktik'] as $t)
                <option value="{{ $t }}" {{ old('tipe', $data->tipe ?? '') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
            <input type="number" name="kapasitas" value="{{ old('kapasitas', $data->kapasitas ?? 40) }}" required min="1"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
</x-form-card>
@endsection
