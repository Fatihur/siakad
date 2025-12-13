@extends('layouts.guru')
@section('title', 'Input Absensi')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('guru.absensi.index') }}" class="hover:text-primary">Absensi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>Input Absensi</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">Input Absensi</h2>
    <p class="text-[#64748B]">{{ $jadwal->mataPelajaran->nama }} - {{ $jadwal->kelas->nama }}</p>
</div>

<div class="card">
    <div class="px-6 py-4 border-b border-stroke flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-white">
                <i class="fas fa-clipboard-list text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-[#1C2434]">Pertemuan ke-{{ $sesi->pertemuan_ke }}</p>
                <p class="text-sm text-[#64748B]">{{ $sesi->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="badge {{ $sesi->status == 'dibuka' ? 'badge-success' : 'badge-danger' }}">
                <i class="fas {{ $sesi->status == 'dibuka' ? 'fa-lock-open' : 'fa-lock' }} mr-1"></i>
                {{ ucfirst($sesi->status) }}
            </span>
            @if($sesi->status == 'dibuka')
            <form action="{{ route('guru.absensi.tutup', $sesi) }}" method="POST" onsubmit="return confirm('Tutup sesi absensi? Anda tidak dapat mengubah absensi setelah ditutup.')">
                @csrf
                <button type="submit" class="btn btn-danger text-sm">
                    <i class="fas fa-lock"></i>
                    <span>Tutup Sesi</span>
                </button>
            </form>
            @endif
        </div>
    </div>
    
    <form action="{{ route('guru.absensi.store', $sesi) }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#F9FAFB] text-left text-xs uppercase text-[#64748B]">
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">NIS</th>
                        <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 font-semibold">Status Kehadiran</th>
                        <th class="px-6 py-4 font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EFF4FB]">
                    @foreach($siswa as $i => $s)
                    <tr class="hover:bg-[#F9FAFB]">
                        <td class="px-6 py-4 text-[#64748B]">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-[#64748B]">{{ $s->nis }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-[#EFF4FB] rounded-lg flex items-center justify-center text-primary font-semibold text-sm">
                                    {{ strtoupper(substr($s->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-[#1C2434]">{{ $s->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <select name="absensi[{{ $s->id }}]" 
                                class="form-input form-select py-2 text-sm {{ $sesi->status == 'ditutup' ? 'bg-[#F9FAFB] cursor-not-allowed' : '' }}" 
                                {{ $sesi->status == 'ditutup' ? 'disabled' : '' }}>
                                @foreach(['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha', 'terlambat' => 'Terlambat'] as $val => $label)
                                <option value="{{ $val }}" {{ ($absensi[$s->id] ?? 'hadir') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <input type="text" name="catatan[{{ $s->id }}]" 
                                class="form-input py-2 text-sm {{ $sesi->status == 'ditutup' ? 'bg-[#F9FAFB] cursor-not-allowed' : '' }}" 
                                placeholder="Opsional..." 
                                {{ $sesi->status == 'ditutup' ? 'disabled' : '' }}>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-[#F9FAFB] border-t border-stroke flex flex-col sm:flex-row gap-3">
            @if($sesi->status == 'dibuka')
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Absensi</span>
            </button>
            @endif
            <a href="{{ route('guru.absensi.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </form>
</div>
@endsection
