@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Dashboard</h2>
    <p class="text-[#64748B]">Selamat datang di Sistem Informasi Akademik</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#EFF4FB] text-primary">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['total_guru'] }}</p>
                <p class="text-sm text-[#64748B]">Total Guru</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-meta-3"><i class="fas fa-arrow-up mr-1"></i>Aktif</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#FEF9C3] text-[#CA8A04]">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['total_siswa'] }}</p>
                <p class="text-sm text-[#64748B]">Total Siswa</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-meta-3"><i class="fas fa-arrow-up mr-1"></i>Aktif</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#FEF2F2] text-meta-1">
                <i class="fas fa-chalkboard text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['total_kelas'] }}</p>
                <p class="text-sm text-[#64748B]">Total Kelas</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-[#64748B]">Semester ini</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="stat-icon bg-[#ECFDF3] text-meta-3">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#1C2434]">{{ $stats['jadwal_aktif'] }}</p>
                <p class="text-sm text-[#64748B]">Jadwal Aktif</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-[#64748B]">Dipublikasi</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Nilai Pending -->
    <div class="xl:col-span-2 card">
        <div class="px-6 py-4 border-b border-stroke flex justify-between items-center">
            <h3 class="font-semibold text-[#1C2434]">Nilai Menunggu Verifikasi</h3>
            <a href="{{ route('admin.verifikasi-nilai.index') }}" class="text-sm text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            @if($nilaiPending->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs uppercase text-[#64748B] bg-[#F9FAFB]">
                                <th class="px-4 py-3 font-semibold">Kelas</th>
                                <th class="px-4 py-3 font-semibold">Mata Pelajaran</th>
                                <th class="px-4 py-3 font-semibold">Guru</th>
                                <th class="px-4 py-3 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFF4FB]">
                            @foreach($nilaiPending as $nilai)
                            <tr class="hover:bg-[#F9FAFB]">
                                <td class="px-4 py-3 font-medium text-[#1C2434]">{{ $nilai->kelas->nama }}</td>
                                <td class="px-4 py-3 text-[#64748B]">{{ $nilai->mataPelajaran->nama }}</td>
                                <td class="px-4 py-3 text-[#64748B]">{{ $nilai->guru->nama }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.verifikasi-nilai.show', $nilai) }}" class="text-primary hover:underline text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>Review
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-2xl text-[#9CA3AF]"></i>
                    </div>
                    <p class="text-[#64748B]">Tidak ada nilai yang menunggu verifikasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Verifikasi -->
    <div class="card">
        <div class="px-6 py-4 border-b border-stroke">
            <h3 class="font-semibold text-[#1C2434]">Status Verifikasi</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-4 bg-[#FEF9C3] rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#CA8A04]/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-[#CA8A04]"></i>
                    </div>
                    <span class="font-medium text-[#1C2434]">Menunggu</span>
                </div>
                <span class="text-2xl font-bold text-[#CA8A04]">{{ $stats['nilai_pending'] }}</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-[#ECFDF3] rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-meta-3/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-meta-3"></i>
                    </div>
                    <span class="font-medium text-[#1C2434]">Terverifikasi</span>
                </div>
                <span class="text-2xl font-bold text-meta-3">{{ $stats['nilai_terverifikasi'] }}</span>
            </div>
            
            @if($semester)
            <div class="mt-6 pt-6 border-t border-stroke">
                <p class="text-xs text-[#64748B] uppercase font-semibold mb-3">Semester Aktif</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#EFF4FB] rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-primary"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-[#1C2434]">{{ $semester->tahunAkademik->tahun }}</p>
                        <p class="text-sm text-[#64748B]">Semester {{ ucfirst($semester->tipe) }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
