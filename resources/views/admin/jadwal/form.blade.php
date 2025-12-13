@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Jadwal' : 'Tambah Jadwal')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Jadwal' : 'Tambah Jadwal'"
    :action="isset($data) ? route('admin.jadwal.update', $data) : route('admin.jadwal.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.jadwal.index')">
    
    @if(!$semester)
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
        <i class="fas fa-exclamation-triangle mr-2"></i>Belum ada semester aktif. Silakan set semester aktif terlebih dahulu.
    </div>
    @else
    <input type="hidden" name="semester_id" value="{{ $semester->id }}">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }} - {{ $k->jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Mapel</option>
                @foreach($mapel as $m)
                <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $data->mata_pelajaran_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Guru</label>
            <select name="guru_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Guru</option>
                @foreach($guru as $g)
                <option value="{{ $g->id }}" {{ old('guru_id', $data->guru_id ?? '') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ruang</label>
            <select name="ruang_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Ruang</option>
                @foreach($ruang as $r)
                <option value="{{ $r->id }}" {{ old('ruang_id', $data->ruang_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
            <select name="hari" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $h)
                <option value="{{ $h }}" {{ old('hari', $data->hari ?? '') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                @endforeach
            </select>
        </div>
        @php $isEdit = isset($data); @endphp
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $isEdit ? substr($data->jam_mulai, 0, 5) : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $isEdit ? substr($data->jam_selesai, 0, 5) : '') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
    @endif
</x-form-card>
@endsection
