@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Siswa' : 'Tambah Siswa')

@php $isEdit = isset($data); @endphp

@section('content')
<x-form-card 
    :title="$isEdit ? 'Edit Siswa' : 'Tambah Siswa'"
    :action="$isEdit ? route('admin.siswa.update', $data) : route('admin.siswa.store')"
    :method="$isEdit ? 'PUT' : 'POST'"
    :backRoute="route('admin.siswa.index')"
    :hasFile="true">
    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $isEdit ? $data->nis : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
            <input type="text" name="nisn" value="{{ old('nisn', $isEdit ? $data->nisn : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id', $isEdit ? $data->kelas_id : '') == $k->id ? 'selected' : '' }}>{{ $k->nama }} - {{ $k->jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $isEdit ? $data->nama : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $isEdit ? $data->user->email : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="L" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $isEdit ? $data->telepon : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
            <input type="text" name="nama_wali" value="{{ old('nama_wali', $isEdit ? $data->nama_wali : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Wali</label>
        <input type="text" name="telepon_wali" value="{{ old('telepon_wali', $isEdit ? $data->telepon_wali : '') }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
        <textarea name="alamat" rows="2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('alamat', $isEdit ? $data->alamat : '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
        <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
    </div>
    @if(!$isEdit)
    <p class="text-sm text-gray-500 bg-yellow-50 p-3 rounded-lg"><i class="fas fa-info-circle mr-2"></i>Password default: password123</p>
    @endif
</x-form-card>
@endsection
