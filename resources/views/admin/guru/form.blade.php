@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Guru' : 'Tambah Guru')

@php $isEdit = isset($data); @endphp

@section('content')
<x-form-card 
    :title="$isEdit ? 'Edit Guru' : 'Tambah Guru'"
    :action="$isEdit ? route('admin.guru.update', $data) : route('admin.guru.store')"
    :method="$isEdit ? 'PUT' : 'POST'"
    :backRoute="route('admin.guru.index')"
    :hasFile="true">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip', $isEdit ? $data->nip : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $isEdit ? $data->nama : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $isEdit ? $data->user->email : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="L" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $isEdit ? $data->tempat_lahir : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $isEdit && $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
        <input type="text" name="telepon" value="{{ old('telepon', $isEdit ? $data->telepon : '') }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
        <textarea name="alamat" rows="2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('alamat', $isEdit ? $data->alamat : '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
        <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
        @if($isEdit && $data->foto)
        <p class="text-sm text-gray-500 mt-1">Foto saat ini: {{ basename($data->foto) }}</p>
        @endif
    </div>
    @if(!$isEdit)
    <p class="text-sm text-gray-500 bg-yellow-50 p-3 rounded-lg"><i class="fas fa-info-circle mr-2"></i>Password default: password123</p>
    @endif
</x-form-card>
@endsection
