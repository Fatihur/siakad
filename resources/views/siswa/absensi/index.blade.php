@extends('layouts.siswa')
@section('title', 'Absensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Riwayat Absensi</h2>
    <p class="text-[#64748B]">{{ $semester ? $semester->tahunAkademik->tahun . ' - Semester ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<!-- Rekap Stats -->
<div class="grid grid-cols-3 sm:grid-cols-5 gap-3 sm:gap-4 mb-6">
    <div class="stat-card text-center">
        <div class="w-10 h-10 bg-[#ECFDF3] rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-check text-meta-3"></i>
        </div>
        <p class="text-xl font-bold text-[#1C2434]">{{ $rekap['hadir'] ?? 0 }}</p>
        <p class="text-xs text-[#64748B]">Hadir</p>
    </div>
    <div class="stat-card text-center">
        <div class="w-10 h-10 bg-[#FEF9C3] rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-envelope text-[#CA8A04]"></i>
        </div>
        <p class="text-xl font-bold text-[#1C2434]">{{ $rekap['izin'] ?? 0 }}</p>
        <p class="text-xs text-[#64748B]">Izin</p>
    </div>
    <div class="stat-card text-center">
        <div class="w-10 h-10 bg-[#E0F2FE] rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-medkit text-meta-5"></i>
        </div>
        <p class="text-xl font-bold text-[#1C2434]">{{ $rekap['sakit'] ?? 0 }}</p>
        <p class="text-xs text-[#64748B]">Sakit</p>
    </div>
    <div class="stat-card text-center">
        <div class="w-10 h-10 bg-[#FEF2F2] rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-times text-meta-1"></i>
        </div>
        <p class="text-xl font-bold text-[#1C2434]">{{ $rekap['alpha'] ?? 0 }}</p>
        <p class="text-xs text-[#64748B]">Alpha</p>
    </div>
    <div class="stat-card text-center">
        <div class="w-10 h-10 bg-[#FEF3C7] rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-clock text-meta-8"></i>
        </div>
        <p class="text-xl font-bold text-[#1C2434]">{{ $rekap['terlambat'] ?? 0 }}</p>
        <p class="text-xs text-[#64748B]">Terlambat</p>
    </div>
</div>

<div class="card">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">Detail Absensi</h3>
    </div>
    <div class="p-6">
        @if($absensi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full min-w-[500px]">
                <thead>
                    <tr class="text-left text-xs uppercase text-[#64748B] bg-[#F9FAFB]">
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Mata Pelajaran</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EFF4FB]">
                    @foreach($absensi as $a)
                    <tr class="hover:bg-[#F9FAFB]">
                        <td class="px-4 py-3 text-sm text-[#64748B]">{{ $a->sesiAbsensi->tanggal->format('d M Y') }}</td>
                        <td class="px-4 py-3 font-medium text-[#1C2434]">{{ $a->sesiAbsensi->jadwal->mataPelajaran->nama }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badges = [
                                    'hadir' => 'badge-success',
                                    'izin' => 'badge-warning', 
                                    'sakit' => 'badge-info',
                                    'alpha' => 'badge-danger',
                                    'terlambat' => 'badge-primary'
                                ];
                            @endphp
                            <span class="badge {{ $badges[$a->status] ?? 'badge-info' }} capitalize">{{ $a->status }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-[#64748B]">{{ $a->catatan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $absensi->links() }}</div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-list text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="font-semibold text-[#1C2434] mb-1">Belum ada data</h3>
            <p class="text-[#64748B]">Belum ada data absensi tercatat</p>
        </div>
        @endif
    </div>
</div>
@endsection
