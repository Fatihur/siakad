@extends('layouts.guru')
@section('title', 'Profil Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Profil Saya</h2>
    <p class="text-[#64748B]">Kelola informasi akun Anda</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="card p-6">
        <div class="text-center">
            @if($guru && $guru->foto)
                <img src="{{ Storage::url($guru->foto) }}" alt="Foto" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
            @else
                <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <h3 class="text-xl font-semibold text-[#1C2434]">{{ $guru->nama ?? $user->name }}</h3>
            <p class="text-[#64748B]">NIP: {{ $guru->nip ?? '-' }}</p>
            <p class="text-sm text-[#64748B] mt-2">{{ $user->email }}</p>
        </div>

        @if($guru)
        <hr class="my-4 border-stroke">
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-[#64748B]">Jenis Kelamin</span>
                <span class="font-medium">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            @if($guru->telepon)
            <div class="flex justify-between">
                <span class="text-[#64748B]">Telepon</span>
                <span class="font-medium">{{ $guru->telepon }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Edit Form -->
    <div class="lg:col-span-2 card p-6">
        <h3 class="text-lg font-semibold text-[#1C2434] mb-6">Edit Profil</h3>
        
        <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nama Lengkap <span class="text-meta-1">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $guru->nama ?? $user->name) }}" class="form-input @error('nama') border-meta-1 @enderror" required>
                    @error('nama')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">Email <span class="text-meta-1">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input @error('email') border-meta-1 @enderror" required>
                    @error('email')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">NIP</label>
                    <input type="text" value="{{ $guru->nip ?? '-' }}" class="form-input bg-gray-100" disabled>
                </div>
                
                <div>
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $guru->telepon ?? '') }}" class="form-input @error('telepon') border-meta-1 @enderror">
                    @error('telepon')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-input @error('alamat') border-meta-1 @enderror">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*" class="form-input @error('foto') border-meta-1 @enderror">
                    <p class="text-xs text-[#64748B] mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                    @error('foto')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="my-6 border-stroke">

            <h4 class="font-medium text-[#1C2434] mb-4">Ubah Password</h4>
            <p class="text-sm text-[#64748B] mb-4">Kosongkan jika tidak ingin mengubah password</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input @error('password') border-meta-1 @enderror">
                    @error('password')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
