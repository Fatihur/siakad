@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran'"
    :action="isset($data) ? route('admin.mata-pelajaran.update', $data) : route('admin.mata-pelajaran.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.mata-pelajaran.index')">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
            <input type="text" name="kode" value="{{ old('kode', $data->kode ?? '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
            <select name="kelompok" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="wajib" {{ old('kelompok', $data->kelompok ?? '') == 'wajib' ? 'selected' : '' }}>Wajib</option>
                <option value="peminatan" {{ old('kelompok', $data->kelompok ?? '') == 'peminatan' ? 'selected' : '' }}>Peminatan</option>
                <option value="muatan_lokal" {{ old('kelompok', $data->kelompok ?? '') == 'muatan_lokal' ? 'selected' : '' }}>Muatan Lokal</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam per Minggu</label>
            <input type="number" name="jam_per_minggu" value="{{ old('jam_per_minggu', $data->jam_per_minggu ?? 2) }}" required min="1"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
</x-form-card>
@endsection
