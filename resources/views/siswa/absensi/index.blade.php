@extends('layouts.siswa')
@section('title', 'Absensi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
    <p class="text-gray-500">{{ $semester ? $semester->tahunAkademik->tahun . ' - ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<!-- Rekap -->
<div class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4 mb-6">
    @foreach(['hadir' => ['green', 'check'], 'izin' => ['yellow', 'envelope'], 'sakit' => ['blue', 'medkit'], 'alpha' => ['red', 'times'], 'terlambat' => ['orange', 'clock']] as $status => $config)
    <div class="bg-white rounded-xl p-3 sm:p-4 shadow-sm text-center">
        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-{{ $config[0] }}-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-{{ $config[1] }} text-sm sm:text-base text-{{ $config[0] }}-600"></i>
        </div>
        <p class="text-lg sm:text-2xl font-bold">{{ $rekap[$status] ?? 0 }}</p>
        <p class="text-xs sm:text-sm text-gray-500 capitalize">{{ $status }}</p>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="font-semibold">Detail Absensi</h2>
    </div>
    <div class="p-6">
        @if($absensi->count() > 0)
        <div class="overflow-x-auto">
        <table class="w-full min-w-[500px]">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500 text-sm">
                    <th class="px-2 sm:px-4 py-3">Tanggal</th>
                    <th class="px-2 sm:px-4 py-3">Mata Pelajaran</th>
                    <th class="px-2 sm:px-4 py-3">Status</th>
                    <th class="px-2 sm:px-4 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $a)
                <tr class="border-t">
                    <td class="px-2 sm:px-4 py-3 text-sm">{{ $a->sesiAbsensi->tanggal->format('d/m/Y') }}</td>
                    <td class="px-2 sm:px-4 py-3 text-sm">{{ $a->sesiAbsensi->jadwal->mataPelajaran->nama }}</td>
                    <td class="px-2 sm:px-4 py-3">
                        @php
                            $colors = ['hadir' => 'green', 'izin' => 'yellow', 'sakit' => 'blue', 'alpha' => 'red', 'terlambat' => 'orange'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs bg-{{ $colors[$a->status] }}-100 text-{{ $colors[$a->status] }}-800 capitalize">{{ $a->status }}</span>
                    </td>
                    <td class="px-2 sm:px-4 py-3 text-gray-500 text-sm">{{ $a->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mt-4 overflow-x-auto">{{ $absensi->links() }}</div>
        @else
        <p class="text-gray-500 text-center py-8">Belum ada data absensi</p>
        @endif
    </div>
</div>
@endsection
