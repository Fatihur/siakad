@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Kelas' : 'Tambah Kelas')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Kelas' : 'Tambah Kelas'"
    :action="isset($data) ? route('admin.kelas.update', $data) : route('admin.kelas.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.kelas.index')">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
            <select name="tingkat" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Tingkat</option>
                @foreach(['X', 'XI', 'XII'] as $t)
                <option value="{{ $t }}" {{ old('tingkat', $data->tingkat ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <select name="jurusan_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusan as $j)
                <option value="{{ $j->id }}" {{ old('jurusan_id', $data->jurusan_id ?? '') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rombel</label>
            <input type="text" name="rombel" value="{{ old('rombel', $data->rombel ?? '') }}" placeholder="A, B, C, dst"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
        <input type="number" name="kapasitas" value="{{ old('kapasitas', $data->kapasitas ?? 36) }}" required min="1"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</x-form-card>
@endsection
