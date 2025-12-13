@extends('layouts.app')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-title="Dashboard">
    <i class="fas fa-th-large w-5"></i> <span class="sidebar-text">Dashboard</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Master Data</p>
<a href="{{ route('admin.tahun-akademik.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.tahun-akademik.*') ? 'active' : '' }}" data-title="Tahun Akademik">
    <i class="fas fa-calendar-alt w-5"></i> <span class="sidebar-text">Tahun Akademik</span>
</a>
<a href="{{ route('admin.jurusan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}" data-title="Jurusan">
    <i class="fas fa-layer-group w-5"></i> <span class="sidebar-text">Jurusan</span>
</a>
<a href="{{ route('admin.kelas.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}" data-title="Kelas">
    <i class="fas fa-chalkboard w-5"></i> <span class="sidebar-text">Kelas</span>
</a>
<a href="{{ route('admin.ruang.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.ruang.*') ? 'active' : '' }}" data-title="Ruang">
    <i class="fas fa-door-open w-5"></i> <span class="sidebar-text">Ruang</span>
</a>
<a href="{{ route('admin.mata-pelajaran.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}" data-title="Mata Pelajaran">
    <i class="fas fa-book w-5"></i> <span class="sidebar-text">Mata Pelajaran</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Pengguna</p>
<a href="{{ route('admin.guru.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}" data-title="Guru">
    <i class="fas fa-user-tie w-5"></i> <span class="sidebar-text">Guru</span>
</a>
<a href="{{ route('admin.siswa.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}" data-title="Siswa">
    <i class="fas fa-user-graduate w-5"></i> <span class="sidebar-text">Siswa</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Akademik</p>
<a href="{{ route('admin.jadwal.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" data-title="Jadwal">
    <i class="fas fa-calendar-week w-5"></i> <span class="sidebar-text">Jadwal</span>
</a>
<a href="{{ route('admin.verifikasi-nilai.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.verifikasi-nilai.*') ? 'active' : '' }}" data-title="Verifikasi Nilai">
    <i class="fas fa-check-double w-5"></i> <span class="sidebar-text">Verifikasi Nilai</span>
</a>
<a href="{{ route('admin.pengumuman.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}" data-title="Pengumuman">
    <i class="fas fa-bullhorn w-5"></i> <span class="sidebar-text">Pengumuman</span>
</a>
@endsection
