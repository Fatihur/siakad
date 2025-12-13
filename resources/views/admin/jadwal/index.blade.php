@extends('layouts.admin')
@section('title', 'Jadwal')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Jadwal Pelajaran</h2>
    <p class="text-[#64748B]">Kelola jadwal pelajaran {{ $semester ? '- ' . $semester->tahunAkademik->tahun . ' Semester ' . ucfirst($semester->tipe) : '' }}</p>
</div>

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.jadwal.generator') }}" class="btn btn-success">
            <i class="fas fa-magic"></i>
            <span>Generator Jadwal</span>
        </a>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span>Tambah Manual</span>
        </a>
        <a href="{{ route('admin.jam-istirahat.index') }}" class="btn btn-outline">
            <i class="fas fa-coffee"></i>
            <span>Jam Istirahat</span>
        </a>
    </div>
    
    <!-- View Toggle -->
    <div class="flex items-center gap-2 bg-[#F1F5F9] p-1 rounded-lg">
        <button type="button" id="btn-table-view" class="view-toggle px-4 py-2 rounded-md text-sm font-medium transition-all active">
            <i class="fas fa-table mr-2"></i>Tabel
        </button>
        <button type="button" id="btn-calendar-view" class="view-toggle px-4 py-2 rounded-md text-sm font-medium transition-all">
            <i class="fas fa-calendar-alt mr-2"></i>Kalender
        </button>
    </div>
</div>

<!-- Filter untuk Calendar View -->
<div id="calendar-filter" class="card p-4 mb-6 hidden">
    <div class="flex flex-wrap items-center gap-4">
        <div>
            <label class="form-label mb-1">Filter Kelas</label>
            <select id="filter-kelas" class="form-input form-select py-2">
                <option value="">Semua Kelas</option>
                @php
                    $kelasList = $data->pluck('kelas')->unique('id');
                @endphp
                @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label mb-1">Filter Guru</label>
            <select id="filter-guru" class="form-input form-select py-2">
                <option value="">Semua Guru</option>
                @php
                    $guruList = $data->pluck('guru')->unique('id');
                @endphp
                @foreach($guruList as $guru)
                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Table View -->
<div id="table-view" class="card">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">Daftar Jadwal</h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full datatable" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">Hari</th>
                        <th class="px-4 py-3 text-left">Jam</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left">Guru</th>
                        <th class="px-4 py-3 text-left">Ruang</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="font-medium text-[#1C2434] capitalize">{{ $item->hari }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-[#64748B]">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-[#1C2434]">{{ $item->kelas->nama }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge badge-primary">{{ $item->mataPelajaran->kode }}</span>
                            <span class="text-sm text-[#64748B] ml-1">{{ $item->mataPelajaran->nama }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-primary rounded flex items-center justify-center text-white text-xs font-semibold">
                                    {{ strtoupper(substr($item->guru->nama, 0, 1)) }}
                                </div>
                                <span class="text-[#1C2434]">{{ Str::limit($item->guru->nama, 20) }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-[#64748B]">{{ $item->ruang->nama }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.jadwal.edit', $item) }}" class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-[#64748B] hover:text-meta-1 hover:bg-[#FEF2F2] rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Calendar View -->
<div id="calendar-view" class="card hidden">
    <div class="px-6 py-4 border-b border-stroke flex items-center justify-between">
        <h3 class="font-semibold text-[#1C2434]">Kalender Jadwal Mingguan</h3>
        <div class="text-sm text-[#64748B]">
            <i class="fas fa-info-circle mr-1"></i>
            Klik jadwal untuk edit
        </div>
    </div>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[900px]">
                <thead>
                    <tr>
                        <th class="border border-stroke bg-[#F9FAFB] p-3 w-20 text-[#64748B] text-sm font-medium">Jam</th>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <th class="border border-stroke bg-primary text-white p-3 text-sm font-medium">{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    @php
                        $jamSlots = [];
                        foreach ($data as $item) {
                            $key = substr($item->jam_mulai, 0, 5);
                            if (!isset($jamSlots[$key])) {
                                $jamSlots[$key] = [
                                    'mulai' => substr($item->jam_mulai, 0, 5),
                                    'selesai' => substr($item->jam_selesai, 0, 5),
                                ];
                            }
                        }
                        
                        $istirahatMap = $jamIstirahat->keyBy('setelah_jam_ke');
                        ksort($jamSlots);
                        
                        $jadwalByHariJam = [];
                        foreach ($data as $item) {
                            $key = $item->hari . '_' . substr($item->jam_mulai, 0, 5);
                            if (!isset($jadwalByHariJam[$key])) {
                                $jadwalByHariJam[$key] = [];
                            }
                            $jadwalByHariJam[$key][] = $item;
                        }
                        
                        $slotsArray = array_values($jamSlots);
                        $breakAfterSlots = [];
                        foreach ($istirahatMap as $afterJam => $ist) {
                            if (isset($slotsArray[$afterJam - 1])) {
                                $breakAfterSlots[$slotsArray[$afterJam - 1]['mulai']] = $ist;
                            }
                        }
                    @endphp
                    
                    @forelse($jamSlots as $jam => $slot)
                    <tr class="calendar-row">
                        <td class="border border-stroke bg-[#F9FAFB] p-2 text-center">
                            <div class="text-sm font-medium text-[#1C2434]">{{ $slot['mulai'] }}</div>
                            <div class="text-xs text-[#64748B]">{{ $slot['selesai'] }}</div>
                        </td>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                        <td class="border border-stroke p-1 align-top calendar-cell" data-hari="{{ $hari }}" data-jam="{{ $jam }}">
                            @php
                                $key = $hari . '_' . $jam;
                                $jadwalCell = $jadwalByHariJam[$key] ?? [];
                            @endphp
                            @foreach($jadwalCell as $jadwal)
                            <a href="{{ route('admin.jadwal.edit', $jadwal) }}" 
                               class="jadwal-item block p-2 mb-1 rounded-lg text-xs transition-all hover:shadow-md bg-primary/10 hover:bg-primary/20 border border-primary/30"
                               data-kelas="{{ $jadwal->kelas_id }}"
                               data-guru="{{ $jadwal->guru_id }}">
                                <div class="font-semibold text-[#1C2434] truncate">{{ $jadwal->mataPelajaran->kode }}</div>
                                <div class="text-[#64748B] truncate">{{ $jadwal->kelas->nama }}</div>
                                <div class="text-[#64748B] truncate">{{ Str::limit($jadwal->guru->nama, 15) }}</div>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-meta-3/20 text-meta-3">
                                        {{ $jadwal->ruang->kode ?? $jadwal->ruang->nama }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </td>
                        @endforeach
                    </tr>
                    
                    @if(isset($breakAfterSlots[$jam]))
                    @php $ist = $breakAfterSlots[$jam]; @endphp
                    <tr class="istirahat-row">
                        <td class="border border-stroke bg-warning/20 p-2 text-center" colspan="7">
                            <div class="flex items-center justify-center gap-2 text-warning">
                                <i class="fas fa-coffee"></i>
                                <span class="font-medium">{{ $ist->nama }}</span>
                                <span class="text-sm opacity-75">( {{ $ist->durasi_menit }} menit )</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="border border-stroke p-8 text-center text-[#64748B]">
                            <i class="fas fa-calendar-times text-4xl mb-3 text-[#D1D5DB]"></i>
                            <p>Belum ada jadwal</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Legend -->
    <div class="px-6 py-4 border-t border-stroke bg-[#F9FAFB]">
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <span class="text-[#64748B]">Keterangan:</span>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded bg-primary/20 border border-primary/30"></span>
                <span class="text-[#64748B]">Jadwal Pelajaran</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded bg-warning/30 flex items-center justify-center">
                    <i class="fas fa-coffee text-warning text-[8px]"></i>
                </span>
                <span class="text-[#64748B]">Istirahat</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .view-toggle { color: #64748B; }
    .view-toggle.active { background-color: white; color: #3C50E0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .calendar-cell { min-height: 80px; min-width: 120px; }
    .jadwal-item.hidden { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#btn-table-view').click(function() {
        $(this).addClass('active');
        $('#btn-calendar-view').removeClass('active');
        $('#table-view').removeClass('hidden');
        $('#calendar-view').addClass('hidden');
        $('#calendar-filter').addClass('hidden');
    });
    
    $('#btn-calendar-view').click(function() {
        $(this).addClass('active');
        $('#btn-table-view').removeClass('active');
        $('#calendar-view').removeClass('hidden');
        $('#table-view').addClass('hidden');
        $('#calendar-filter').removeClass('hidden');
    });
    
    function filterCalendar() {
        const kelasId = $('#filter-kelas').val();
        const guruId = $('#filter-guru').val();
        
        $('.jadwal-item').each(function() {
            const itemKelas = $(this).data('kelas').toString();
            const itemGuru = $(this).data('guru').toString();
            
            let show = true;
            if (kelasId && itemKelas !== kelasId) show = false;
            if (guruId && itemGuru !== guruId) show = false;
            
            $(this).toggleClass('hidden', !show);
        });
    }
    
    $('#filter-kelas, #filter-guru').change(filterCalendar);
});
</script>
@endpush
@endsection
