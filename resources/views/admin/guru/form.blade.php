@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Guru' : 'Tambah Guru')

@php $isEdit = isset($data); @endphp

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('admin.guru.index') }}" class="hover:text-primary">Guru</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>{{ $isEdit ? 'Edit' : 'Tambah' }}</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">{{ $isEdit ? 'Edit Guru' : 'Tambah Guru Baru' }}</h2>
    <p class="text-[#64748B]">{{ $isEdit ? 'Perbarui data guru' : 'Tambahkan data guru baru' }}</p>
</div>

<div class="card max-w-4xl">
    <form action="{{ $isEdit ? route('admin.guru.update', $data) : route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif
        
        <div class="p-6 space-y-6">
            @if(!$isEdit)
            <div class="alert alert-info">
                <i class="fas fa-info-circle text-meta-5"></i>
                <span>Password default untuk guru baru: <strong>password123</strong></span>
            </div>
            @endif

            <div>
                <h4 class="text-sm font-semibold text-[#1C2434] uppercase tracking-wider mb-4">Data Identitas</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">NIP <span class="text-meta-1">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip', $isEdit ? $data->nip : '') }}" required class="form-input" placeholder="Nomor Induk Pegawai">
                    </div>
                    <div>
                        <label class="form-label">Nama Lengkap <span class="text-meta-1">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $isEdit ? $data->nama : '') }}" required class="form-input" placeholder="Nama lengkap guru">
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-[#1C2434] uppercase tracking-wider mb-4">Data Pribadi</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Email <span class="text-meta-1">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $isEdit ? $data->user->email : '') }}" required class="form-input" placeholder="email@example.com">
                    </div>
                    <div>
                        <label class="form-label">Jenis Kelamin <span class="text-meta-1">*</span></label>
                        <select name="jenis_kelamin" required class="form-input form-select">
                            <option value="L" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $isEdit ? $data->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $isEdit ? $data->tempat_lahir : '') }}" class="form-input" placeholder="Kota kelahiran">
                    </div>
                    <div>
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $isEdit && $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $isEdit ? $data->telepon : '') }}" class="form-input" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-input" placeholder="Alamat lengkap">{{ old('alamat', $isEdit ? $data->alamat : '') }}</textarea>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-[#1C2434] uppercase tracking-wider mb-4">Foto</h4>
                <div class="flex items-start gap-4">
                    @if($isEdit && $data->foto)
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-[#F9FAFB] flex-shrink-0">
                        <img src="{{ Storage::url($data->foto) }}" alt="Foto" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="foto" accept="image/*" class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#EFF4FB] file:text-primary hover:file:bg-[#dce5f5]">
                        <p class="text-xs text-[#64748B] mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-[#F9FAFB] border-t border-stroke flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>{{ $isEdit ? 'Perbarui' : 'Simpan' }}</span>
            </button>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </form>
</div>
@endsection
