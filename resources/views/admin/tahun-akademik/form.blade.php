@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik')

@section('content')
<x-form-card 
    :title="isset($data) ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik'"
    :action="isset($data) ? route('admin.tahun-akademik.update', $data) : route('admin.tahun-akademik.store')"
    :method="isset($data) ? 'PUT' : 'POST'"
    :backRoute="route('admin.tahun-akademik.index')">
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akademik</label>
        <input type="text" name="tahun" value="{{ old('tahun', $data->tahun ?? '') }}" required placeholder="2024/2025"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <p class="text-sm text-gray-500 mt-1">Format: 2024/2025</p>
    </div>
</x-form-card>
@endsection
