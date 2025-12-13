@extends('layouts.app')

@section('sidebar')
<a href="{{ route('siswa.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" data-title="Dashboard">
    <i class="fas fa-th-large w-5"></i> <span class="sidebar-text">Dashboard</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Akademik</p>
<a href="{{ route('siswa.jadwal.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.jadwal.*') ? 'active' : '' }}" data-title="Jadwal">
    <i class="fas fa-calendar-week w-5"></i> <span class="sidebar-text">Jadwal</span>
</a>
<a href="{{ route('siswa.nilai.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}" data-title="Nilai">
    <i class="fas fa-star w-5"></i> <span class="sidebar-text">Nilai</span>
</a>
<a href="{{ route('siswa.absensi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}" data-title="Absensi">
    <i class="fas fa-clipboard-check w-5"></i> <span class="sidebar-text">Absensi</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Pembelajaran</p>
<a href="{{ route('siswa.materi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}" data-title="Materi">
    <i class="fas fa-file-alt w-5"></i> <span class="sidebar-text">Materi</span>
</a>
<a href="{{ route('siswa.tugas.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}" data-title="Tugas">
    <i class="fas fa-tasks w-5"></i> <span class="sidebar-text">Tugas</span>
</a>
@endsection
