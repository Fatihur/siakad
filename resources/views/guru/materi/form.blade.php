@extends('layouts.guru')
@section('title', isset($data) ? 'Edit Materi' : 'Tambah Materi')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Materi' : 'Tambah Materi'"
    :action="isset($data) ? route('guru.materi.update', $data) : route('guru.materi.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('guru.materi.index')"
    :hasFile="true">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas - Mata Pelajaran</label>
            <select name="kelas_mapel" id="kelas_mapel" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih</option>
                @foreach($jadwal as $j)
                <option value="{{ $j->kelas_id }}-{{ $j->mata_pelajaran_id }}" {{ (old('kelas_id', $data->kelas_id ?? '') == $j->kelas_id && old('mata_pelajaran_id', $data->mata_pelajaran_id ?? '') == $j->mata_pelajaran_id) ? 'selected' : '' }}>
                    {{ $j->kelas->nama }} - {{ $j->mataPelajaran->nama }}
                </option>
                @endforeach
            </select>
            <input type="hidden" name="kelas_id" id="kelas_id" value="{{ old('kelas_id', $data->kelas_id ?? '') }}">
            <input type="hidden" name="mata_pelajaran_id" id="mata_pelajaran_id" value="{{ old('mata_pelajaran_id', $data->mata_pelajaran_id ?? '') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Visibilitas</label>
            <select name="visibilitas" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="draft" {{ old('visibilitas', $data->visibilitas ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publik" {{ old('visibilitas', $data->visibilitas ?? '') == 'publik' ? 'selected' : '' }}>Publik</option>
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
        <input type="text" name="judul" value="{{ old('judul', $data->judul ?? '') }}" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $data->deskripsi ?? '') }}</textarea>
    </div>
    @php $isEdit = isset($data); @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">File Materi</label>
            <input type="file" name="file" class="w-full px-4 py-2 border rounded-lg">
            @if($isEdit && $data->file_path)
            <p class="text-sm text-gray-500 mt-1">File: {{ basename($data->file_path) }}</p>
            @endif
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Atau URL Link</label>
            <input type="url" name="url_link" value="{{ old('url_link', $isEdit ? $data->url_link : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://...">
        </div>
    </div>
</x-form-card>

<script>
document.getElementById('kelas_mapel').addEventListener('change', function() {
    const [kelas, mapel] = this.value.split('-');
    document.getElementById('kelas_id').value = kelas || '';
    document.getElementById('mata_pelajaran_id').value = mapel || '';
});
</script>
@endsection
