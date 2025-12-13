@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Pengumuman' : 'Tambah Pengumuman'"
    :action="isset($data) ? route('admin.pengumuman.update', $data) : route('admin.pengumuman.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.pengumuman.index')">
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
        <input type="text" name="judul" value="{{ old('judul', $data->judul ?? '') }}" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
        <textarea name="konten" rows="5" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('konten', $data->konten ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lingkup</label>
            <select name="lingkup" id="lingkup" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="global" {{ old('lingkup', $data->lingkup ?? '') == 'global' ? 'selected' : '' }}>Global (Semua)</option>
                <option value="kelas" {{ old('lingkup', $data->lingkup ?? '') == 'kelas' ? 'selected' : '' }}>Per Kelas</option>
                <option value="jurusan" {{ old('lingkup', $data->lingkup ?? '') == 'jurusan' ? 'selected' : '' }}>Per Jurusan</option>
            </select>
        </div>
        <div id="kelas-field" style="display: none;">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
        <div id="jurusan-field" style="display: none;">
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <select name="jurusan_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusan as $j)
                <option value="{{ $j->id }}" {{ old('jurusan_id', $data->jurusan_id ?? '') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>
        @php $isEdit = isset($data); @endphp
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
            <input type="datetime-local" name="dipublikasi_pada" value="{{ old('dipublikasi_pada', $isEdit && $data->dipublikasi_pada ? $data->dipublikasi_pada->format('Y-m-d\TH:i') : '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
</x-form-card>

<script>
document.getElementById('lingkup').addEventListener('change', function() {
    document.getElementById('kelas-field').style.display = this.value === 'kelas' ? 'block' : 'none';
    document.getElementById('jurusan-field').style.display = this.value === 'jurusan' ? 'block' : 'none';
});
document.getElementById('lingkup').dispatchEvent(new Event('change'));
</script>
@endsection
