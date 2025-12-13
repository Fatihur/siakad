@extends('layouts.app')

@section('sidebar')
<div class="sidebar-group-title">Menu</div>
<a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-th-large w-5 text-center"></i>
    <span class="sidebar-text">Dashboard</span>
</a>

<div class="sidebar-group-title">Master Data</div>
<a href="{{ route('admin.tahun-akademik.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.tahun-akademik.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-alt w-5 text-center"></i>
    <span class="sidebar-text">Tahun Akademik</span>
</a>
<a href="{{ route('admin.jurusan.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
    <i class="fas fa-layer-group w-5 text-center"></i>
    <span class="sidebar-text">Jurusan</span>
</a>
<a href="{{ route('admin.kelas.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
    <i class="fas fa-chalkboard w-5 text-center"></i>
    <span class="sidebar-text">Kelas</span>
</a>
<a href="{{ route('admin.ruang.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.ruang.*') ? 'active' : '' }}">
    <i class="fas fa-door-open w-5 text-center"></i>
    <span class="sidebar-text">Ruang</span>
</a>
<a href="{{ route('admin.mata-pelajaran.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
    <i class="fas fa-book w-5 text-center"></i>
    <span class="sidebar-text">Mata Pelajaran</span>
</a>

<div class="sidebar-group-title">Pengguna</div>
<a href="{{ route('admin.guru.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
    <i class="fas fa-user-tie w-5 text-center"></i>
    <span class="sidebar-text">Guru</span>
</a>
<a href="{{ route('admin.siswa.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
    <i class="fas fa-user-graduate w-5 text-center"></i>
    <span class="sidebar-text">Siswa</span>
</a>

<div class="sidebar-group-title">Akademik</div>
<a href="{{ route('admin.jadwal.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-week w-5 text-center"></i>
    <span class="sidebar-text">Jadwal</span>
</a>
<a href="{{ route('admin.jam-istirahat.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.jam-istirahat.*') ? 'active' : '' }}">
    <i class="fas fa-coffee w-5 text-center"></i>
    <span class="sidebar-text">Jam Istirahat</span>
</a>
<a href="{{ route('admin.verifikasi-nilai.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.verifikasi-nilai.*') ? 'active' : '' }}">
    <i class="fas fa-check-double w-5 text-center"></i>
    <span class="sidebar-text">Verifikasi Nilai</span>
</a>
<a href="{{ route('admin.pengumuman.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
    <i class="fas fa-bullhorn w-5 text-center"></i>
    <span class="sidebar-text">Pengumuman</span>
</a>
@endsection
