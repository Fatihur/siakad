@extends('layouts.app')

@section('sidebar')
<div class="sidebar-group-title">Menu</div>
<a href="{{ route('siswa.dashboard') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
    <i class="fas fa-th-large w-5 text-center"></i>
    <span class="sidebar-text">Dashboard</span>
</a>

<div class="sidebar-group-title">Akademik</div>
<a href="{{ route('siswa.jadwal.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.jadwal.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-week w-5 text-center"></i>
    <span class="sidebar-text">Jadwal</span>
</a>
<a href="{{ route('siswa.absensi.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-check w-5 text-center"></i>
    <span class="sidebar-text">Absensi</span>
</a>
<a href="{{ route('siswa.nilai.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}">
    <i class="fas fa-star w-5 text-center"></i>
    <span class="sidebar-text">Nilai</span>
</a>

<div class="sidebar-group-title">Pembelajaran</div>
<a href="{{ route('siswa.materi.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}">
    <i class="fas fa-file-alt w-5 text-center"></i>
    <span class="sidebar-text">Materi</span>
</a>
<a href="{{ route('siswa.tugas.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}">
    <i class="fas fa-tasks w-5 text-center"></i>
    <span class="sidebar-text">Tugas</span>
</a>
@endsection
