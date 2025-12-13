@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Jurusan' : 'Tambah Jurusan')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Jurusan' : 'Tambah Jurusan'"
    :action="isset($data) ? route('admin.jurusan.update', $data) : route('admin.jurusan.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.jurusan.index')">
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Jurusan</label>
        <input type="text" name="kode" value="{{ old('kode', $data->kode ?? '') }}" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jurusan</label>
        <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $data->deskripsi ?? '') }}</textarea>
    </div>
</x-form-card>
@endsection
