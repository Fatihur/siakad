@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@php $isEdit = isset($data); @endphp

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="hover:text-primary">Mata Pelajaran</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>{{ $isEdit ? 'Edit' : 'Tambah' }}</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">{{ $isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</h2>
    <p class="text-[#64748B]">{{ $isEdit ? 'Perbarui data mata pelajaran' : 'Tambahkan mata pelajaran baru' }}</p>
</div>

<div class="card max-w-4xl">
    <form action="{{ $isEdit ? route('admin.mata-pelajaran.update', $data) : route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif
        
        <div class="p-6 space-y-6">
            <div>
                <h4 class="text-sm font-semibold text-[#1C2434] uppercase tracking-wider mb-4">Informasi Mata Pelajaran</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Kode <span class="text-meta-1">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode', $data->kode ?? '') }}" required
                            class="form-input" placeholder="Contoh: MTK">
                    </div>
                    <div>
                        <label class="form-label">Nama <span class="text-meta-1">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" required
                            class="form-input" placeholder="Nama mata pelajaran">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="form-label">Kelompok <span class="text-meta-1">*</span></label>
                        <select name="kelompok" required class="form-input form-select">
                            <option value="wajib" {{ old('kelompok', $data->kelompok ?? '') == 'wajib' ? 'selected' : '' }}>Wajib</option>
                            <option value="peminatan" {{ old('kelompok', $data->kelompok ?? '') == 'peminatan' ? 'selected' : '' }}>Peminatan</option>
                            <option value="muatan_lokal" {{ old('kelompok', $data->kelompok ?? '') == 'muatan_lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jam per Minggu <span class="text-meta-1">*</span></label>
                        <input type="number" name="jam_per_minggu" value="{{ old('jam_per_minggu', $data->jam_per_minggu ?? 2) }}" required min="1"
                            class="form-input" placeholder="2">
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-[#1C2434] uppercase tracking-wider mb-4">Guru Pengajar</h4>
                <p class="text-sm text-[#64748B] mb-4">Pilih guru yang mengajar mata pelajaran ini (bisa lebih dari satu)</p>
                
                @if($guru->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($guru as $g)
                    <label class="flex items-center gap-3 p-3 border border-stroke rounded-lg cursor-pointer hover:border-primary hover:bg-[#EFF4FB]/50 transition-all has-[:checked]:border-primary has-[:checked]:bg-[#EFF4FB]">
                        <input type="checkbox" name="guru_id[]" value="{{ $g->id }}" 
                            class="w-4 h-4 text-primary border-[#E2E8F0] rounded focus:ring-primary"
                            {{ (collect(old('guru_id', $isEdit ? $data->guru->pluck('id')->toArray() : []))->contains($g->id)) ? 'checked' : '' }}>
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-[#1C2434] text-sm truncate">{{ $g->nama }}</p>
                                <p class="text-xs text-[#64748B]">{{ $g->nip }}</p>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6 bg-[#F9FAFB] rounded-lg">
                    <i class="fas fa-user-slash text-2xl text-[#9CA3AF] mb-2"></i>
                    <p class="text-[#64748B]">Belum ada data guru aktif</p>
                </div>
                @endif
            </div>
        </div>

        <div class="px-6 py-4 bg-[#F9FAFB] border-t border-stroke flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>{{ $isEdit ? 'Perbarui' : 'Simpan' }}</span>
            </button>
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </form>
</div>
@endsection
