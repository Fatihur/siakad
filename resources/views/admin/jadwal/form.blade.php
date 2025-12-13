@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Jadwal' : 'Tambah Jadwal')

@php $isEdit = isset($data); @endphp

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('admin.jadwal.index') }}" class="hover:text-primary">Jadwal</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>{{ $isEdit ? 'Edit' : 'Tambah' }}</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">{{ $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h2>
    <p class="text-[#64748B]">{{ $isEdit ? 'Perbarui data jadwal' : 'Tambahkan jadwal baru' }}</p>
</div>

@if(!$semester)
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    <span>Belum ada semester aktif. Silakan set semester aktif terlebih dahulu.</span>
</div>
@else
<div class="card max-w-3xl">
    <form action="{{ $isEdit ? route('admin.jadwal.update', $data) : route('admin.jadwal.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif
        <input type="hidden" name="semester_id" value="{{ $semester->id }}">
        
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Kelas <span class="text-meta-1">*</span></label>
                    <select name="kelas_id" required class="form-input form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }} - {{ $k->jurusan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Ruang <span class="text-meta-1">*</span></label>
                    <select name="ruang_id" required class="form-input form-select">
                        <option value="">Pilih Ruang</option>
                        @foreach($ruang as $r)
                        <option value="{{ $r->id }}" {{ old('ruang_id', $data->ruang_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Mata Pelajaran <span class="text-meta-1">*</span></label>
                    <select name="mata_pelajaran_id" id="mapel-select" required class="form-input form-select">
                        <option value="">Pilih Mapel</option>
                        @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $data->mata_pelajaran_id ?? '') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Guru Pengajar <span class="text-meta-1">*</span></label>
                    <select name="guru_id" id="guru-select" required class="form-input form-select">
                        <option value="">Pilih Mata Pelajaran dahulu</option>
                    </select>
                    <p class="text-xs text-[#64748B] mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Pilih mata pelajaran untuk melihat daftar guru
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Hari <span class="text-meta-1">*</span></label>
                    <select name="hari" required class="form-input form-select">
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $h)
                        <option value="{{ $h }}" {{ old('hari', $data->hari ?? '') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jam Mulai <span class="text-meta-1">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $isEdit ? substr($data->jam_mulai, 0, 5) : '') }}" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Jam Selesai <span class="text-meta-1">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $isEdit ? substr($data->jam_selesai, 0, 5) : '') }}" required class="form-input">
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-[#F9FAFB] border-t border-stroke flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>{{ $isEdit ? 'Perbarui' : 'Simpan' }}</span>
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </form>
</div>
@endif

@push('scripts')
<script>
$(document).ready(function() {
    const currentGuruId = '{{ old('guru_id', $data->guru_id ?? '') }}';
    
    function fetchGuruByMapel(mapelId) {
        const guruSelect = $('#guru-select');
        
        if (!mapelId) {
            guruSelect.html('<option value="">Pilih Mata Pelajaran dahulu</option>');
            return;
        }
        
        // Show loading
        guruSelect.html('<option value="">Memuat...</option>');
        
        // AJAX request to get guru
        $.ajax({
            url: `/admin/mata-pelajaran/${mapelId}/guru`,
            method: 'GET',
            success: function(guruData) {
                guruSelect.empty();
                
                if (guruData.length === 0) {
                    guruSelect.html('<option value="">Belum ada guru untuk mapel ini</option>');
                    return;
                }
                
                guruSelect.append('<option value="">Pilih Guru</option>');
                guruData.forEach(function(guru) {
                    const selected = guru.id == currentGuruId ? 'selected' : '';
                    guruSelect.append(`<option value="${guru.id}" ${selected}>${guru.nama}</option>`);
                });
                
                // Auto-select first if only one guru and no current selection
                if (guruData.length === 1 && !currentGuruId) {
                    guruSelect.val(guruData[0].id);
                }
            },
            error: function() {
                guruSelect.html('<option value="">Gagal memuat data guru</option>');
            }
        });
    }
    
    // Initial load if mapel is selected
    const initialMapelId = $('#mapel-select').val();
    if (initialMapelId) {
        fetchGuruByMapel(initialMapelId);
    }
    
    // On mapel change - fetch guru via AJAX
    $('#mapel-select').change(function() {
        fetchGuruByMapel($(this).val());
    });
});
</script>
@endpush
@endsection
