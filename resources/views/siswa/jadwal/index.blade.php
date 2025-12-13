@extends('layouts.siswa')
@section('title', 'Jadwal')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Jadwal Pelajaran</h2>
    <p class="text-[#64748B]">{{ $semester ? $semester->tahunAkademik->tahun . ' - Semester ' . ucfirst($semester->tipe) : 'Tidak ada semester aktif' }}</p>
</div>

<div class="card">
    <div class="p-6">
        @if(count($jadwal) > 0)
        <div class="space-y-8">
            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                @if(isset($jadwal[$hari]))
                @php $isToday = strtolower(now()->locale('id')->dayName) == $hari; @endphp
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $isToday ? 'bg-primary text-white' : 'bg-[#F9FAFB] text-[#64748B]' }}">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-[#1C2434] capitalize">{{ $hari }}</h3>
                            @if($isToday)
                            <span class="text-xs text-primary font-medium">Hari Ini</span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-3 pl-[52px]">
                        @foreach($jadwal[$hari] as $j)
                        <div class="flex items-center justify-between p-4 border border-stroke rounded-lg hover:border-primary hover:shadow-card transition-all {{ $isToday ? 'bg-[#EFF4FB]/50' : 'bg-white' }}">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-primary rounded-lg flex items-center justify-center text-white">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#1C2434]">{{ $j->mataPelajaran->nama }}</p>
                                    <p class="text-sm text-[#64748B]">{{ $j->guru->nama }} &bull; {{ $j->ruang->nama }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-primary">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="font-semibold text-[#1C2434] mb-1">Tidak ada jadwal</h3>
            <p class="text-[#64748B]">Jadwal pelajaran belum tersedia</p>
        </div>
        @endif
    </div>
</div>
@endsection
