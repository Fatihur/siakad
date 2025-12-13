@extends('layouts.app')

@section('sidebar')
<div class="sidebar-group-title">Menu</div>
<a href="{{ route('guru.dashboard') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
    <i class="fas fa-th-large w-5 text-center"></i>
    <span class="sidebar-text">Dashboard</span>
</a>

<div class="sidebar-group-title">Mengajar</div>
<a href="{{ route('guru.absensi.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('guru.absensi.*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-check w-5 text-center"></i>
    <span class="sidebar-text">Absensi</span>
</a>
<a href="{{ route('guru.nilai.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}">
    <i class="fas fa-star w-5 text-center"></i>
    <span class="sidebar-text">Nilai</span>
</a>

<div class="sidebar-group-title">Pembelajaran</div>
<a href="{{ route('guru.materi.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('guru.materi.*') ? 'active' : '' }}">
    <i class="fas fa-file-alt w-5 text-center"></i>
    <span class="sidebar-text">Materi</span>
</a>
<a href="{{ route('guru.tugas.index') }}" class="sidebar-item flex items-center gap-3 px-5 py-3 rounded-lg mx-3 mb-1 relative {{ request()->routeIs('guru.tugas.*') ? 'active' : '' }}">
    <i class="fas fa-tasks w-5 text-center"></i>
    <span class="sidebar-text">Tugas</span>
</a>
@endsection
