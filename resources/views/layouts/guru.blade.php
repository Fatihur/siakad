@extends('layouts.app')

@section('sidebar')
<a href="{{ route('guru.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" data-title="Dashboard">
    <i class="fas fa-th-large w-5"></i> <span class="sidebar-text">Dashboard</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Mengajar</p>
<a href="{{ route('guru.absensi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('guru.absensi.*') ? 'active' : '' }}" data-title="Absensi">
    <i class="fas fa-clipboard-check w-5"></i> <span class="sidebar-text">Absensi</span>
</a>
<a href="{{ route('guru.nilai.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}" data-title="Nilai">
    <i class="fas fa-star w-5"></i> <span class="sidebar-text">Nilai</span>
</a>
<p class="text-xs text-gray-400 uppercase mt-4 mb-2 px-4 sidebar-section-title">Pembelajaran</p>
<a href="{{ route('guru.materi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('guru.materi.*') ? 'active' : '' }}" data-title="Materi">
    <i class="fas fa-file-alt w-5"></i> <span class="sidebar-text">Materi</span>
</a>
<a href="{{ route('guru.tugas.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('guru.tugas.*') ? 'active' : '' }}" data-title="Tugas">
    <i class="fas fa-tasks w-5"></i> <span class="sidebar-text">Tugas</span>
</a>
@endsection
