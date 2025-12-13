@extends('layouts.admin')
@section('title', 'Generator Jadwal')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-[#64748B] mb-2">
        <a href="{{ route('admin.jadwal.index') }}" class="hover:text-primary">Jadwal</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>Generator</span>
    </div>
    <h2 class="text-2xl font-bold text-[#1C2434]">Generator Jadwal</h2>
    <p class="text-[#64748B]">Buat jadwal dengan cepat untuk satu kelas</p>
</div>

@if(!$semester)
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    <span>Belum ada semester aktif. Silakan set semester aktif terlebih dahulu.</span>
</div>
@else
<div class="card p-6 mb-6">
    <form id="generator-form">
        @csrf
        <input type="hidden" name="semester_id" value="{{ $semester->id }}">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <label class="form-label">Pilih Kelas <span class="text-meta-1">*</span></label>
                <select name="kelas_id" id="kelas_id" required class="form-input form-select">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }} - {{ $k->jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Durasi per Jam Pelajaran</label>
                <select name="durasi" id="durasi" class="form-input form-select">
                    <option value="45">45 menit</option>
                    <option value="40">40 menit</option>
                    <option value="50">50 menit</option>
                </select>
            </div>
            <div>
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai_default" id="jam_mulai_default" value="07:00" class="form-input">
            </div>
            <div>
                <label class="form-label">&nbsp;</label>
                <a href="{{ route('admin.jam-istirahat.index') }}" class="btn btn-outline w-full">
                    <i class="fas fa-coffee"></i>
                    <span>Atur Istirahat</span>
                </a>
            </div>
        </div>

        <!-- Jadwal Grid -->
        <div class="overflow-x-auto border border-stroke rounded-lg">
            <table class="w-full border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="border-r border-primary/50 p-3 w-24">Jam Ke</th>
                        <th class="border-r border-primary/50 p-3">Senin</th>
                        <th class="border-r border-primary/50 p-3">Selasa</th>
                        <th class="border-r border-primary/50 p-3">Rabu</th>
                        <th class="border-r border-primary/50 p-3">Kamis</th>
                        <th class="border-r border-primary/50 p-3">Jumat</th>
                        <th class="p-3">Sabtu</th>
                    </tr>
                </thead>
                <tbody id="jadwal-grid">
                    @php
                        $istirahatMap = $jamIstirahat->keyBy('setelah_jam_ke');
                    @endphp
                    
                    @for($jam = 1; $jam <= 10; $jam++)
                    <tr class="hover:bg-[#F9FAFB] jadwal-row" data-jam="{{ $jam }}">
                        <td class="border border-stroke p-2 text-center font-medium bg-[#F9FAFB]">
                            <span class="jam-ke text-[#1C2434]">{{ $jam }}</span>
                            <div class="text-xs text-[#64748B] jam-waktu"></div>
                        </td>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                        <td class="border border-stroke p-1.5 jadwal-cell" data-jam="{{ $jam }}" data-hari="{{ $hari }}">
                            <div class="space-y-1.5">
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][mapel]" class="mapel-select form-input form-select py-1.5 text-xs" data-jam="{{ $jam }}" data-hari="{{ $hari }}">
                                    <option value="">Mapel</option>
                                    @foreach($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->kode }}</option>
                                    @endforeach
                                </select>
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][guru]" class="guru-select form-input form-select py-1.5 text-xs" data-jam="{{ $jam }}" data-hari="{{ $hari }}">
                                    <option value="">Guru</option>
                                </select>
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][ruang]" class="ruang-select form-input form-select py-1.5 text-xs">
                                    <option value="">Ruang</option>
                                    @foreach($ruang as $r)
                                    <option value="{{ $r->id }}">{{ $r->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    
                    {{-- Baris Istirahat --}}
                    @if($istirahatMap->has($jam))
                    @php $ist = $istirahatMap->get($jam); @endphp
                    <tr class="istirahat-row bg-warning/10" data-after-jam="{{ $jam }}" data-durasi="{{ $ist->durasi_menit }}">
                        <td class="border border-stroke p-2 text-center bg-warning/20" colspan="7">
                            <div class="flex items-center justify-center gap-2 text-warning">
                                <i class="fas fa-coffee"></i>
                                <span class="font-medium">{{ $ist->nama }}</span>
                                <span class="text-sm">( {{ $ist->durasi_menit }} menit )</span>
                                <span class="istirahat-waktu text-sm"></span>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-stroke">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Jadwal</span>
            </button>
            <button type="button" id="clear-all" class="btn btn-outline">
                <i class="fas fa-eraser"></i>
                <span>Bersihkan Semua</span>
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </form>
</div>

<!-- Quick Fill Panel -->
<div class="card p-6">
    <h3 class="font-semibold text-[#1C2434] mb-4"><i class="fas fa-magic mr-2 text-primary"></i>Quick Fill - Isi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="form-label">Mata Pelajaran</label>
            <select id="quick-mapel" class="form-input form-select">
                <option value="">Pilih Mapel</option>
                @foreach($mapel as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Guru</label>
            <select id="quick-guru" class="form-input form-select">
                <option value="">Pilih Mapel dahulu</option>
            </select>
        </div>
        <div>
            <label class="form-label">Ruang</label>
            <select id="quick-ruang" class="form-input form-select">
                <option value="">Pilih Ruang</option>
                @foreach($ruang as $r)
                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" id="apply-quick" class="btn btn-success w-full">
                <i class="fas fa-fill"></i>
                <span>Terapkan</span>
            </button>
        </div>
    </div>
    <p class="text-sm text-[#64748B] mt-3">
        <i class="fas fa-info-circle mr-1 text-primary"></i>
        Klik sel untuk memilih, lalu klik "Terapkan" untuk mengisi otomatis.
    </p>
</div>
@endif

@push('styles')
<style>
    .cell-selected { background-color: #EFF4FB !important; border-color: #3C50E0 !important; }
    .jadwal-cell:hover { background-color: #F9FAFB; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let selectedCells = [];
    let guruCache = {};
    
    const jamIstirahat = @json($jamIstirahat->keyBy('setelah_jam_ke'));

    function fetchGuru(mapelId, callback) {
        if (!mapelId) {
            callback([]);
            return;
        }
        
        if (guruCache[mapelId]) {
            callback(guruCache[mapelId]);
            return;
        }
        
        $.ajax({
            url: `/admin/mata-pelajaran/${mapelId}/guru`,
            method: 'GET',
            success: function(data) {
                guruCache[mapelId] = data;
                callback(data);
            },
            error: function() {
                callback([]);
            }
        });
    }

    function updateJamWaktu() {
        const durasi = parseInt($('#durasi').val());
        const jamMulai = $('#jam_mulai_default').val().split(':');
        let currentMinutes = parseInt(jamMulai[0]) * 60 + parseInt(jamMulai[1]);

        $('.jadwal-row').each(function() {
            const jamKe = parseInt($(this).data('jam'));
            
            const startHour = Math.floor(currentMinutes / 60);
            const startMin = currentMinutes % 60;
            const endMinutes = currentMinutes + durasi;
            const endHour = Math.floor(endMinutes / 60);
            const endMin = endMinutes % 60;

            $(this).find('.jam-waktu').text(
                String(startHour).padStart(2, '0') + ':' + String(startMin).padStart(2, '0') + ' - ' +
                String(endHour).padStart(2, '0') + ':' + String(endMin).padStart(2, '0')
            );
            
            currentMinutes = endMinutes;
            
            if (jamIstirahat[jamKe]) {
                const istirahatDurasi = jamIstirahat[jamKe].durasi_menit;
                const istirahatStart = currentMinutes;
                const istirahatEnd = currentMinutes + istirahatDurasi;
                
                const istStartHour = Math.floor(istirahatStart / 60);
                const istStartMin = istirahatStart % 60;
                const istEndHour = Math.floor(istirahatEnd / 60);
                const istEndMin = istirahatEnd % 60;
                
                $(`.istirahat-row[data-after-jam="${jamKe}"]`).find('.istirahat-waktu').text(
                    '| ' + String(istStartHour).padStart(2, '0') + ':' + String(istStartMin).padStart(2, '0') + ' - ' +
                    String(istEndHour).padStart(2, '0') + ':' + String(istEndMin).padStart(2, '0')
                );
                
                currentMinutes = istirahatEnd;
            }
        });
    }

    updateJamWaktu();
    $('#durasi, #jam_mulai_default').change(updateJamWaktu);

    // Auto-fetch guru when mapel changes in grid
    $(document).on('change', '.mapel-select', function() {
        const mapelId = $(this).val();
        const jam = $(this).data('jam');
        const hari = $(this).data('hari');
        const guruSelect = $(`.guru-select[data-jam="${jam}"][data-hari="${hari}"]`);
        
        guruSelect.empty().append('<option value="">Guru</option>');
        
        if (!mapelId) return;
        
        fetchGuru(mapelId, function(guruData) {
            guruData.forEach(function(guru) {
                guruSelect.append(`<option value="${guru.id}">${guru.nama.substring(0, 15)}</option>`);
            });
            
            // Auto-select first if only one
            if (guruData.length === 1) {
                guruSelect.val(guruData[0].id);
            }
        });
    });

    // Quick mapel change - fetch guru
    $('#quick-mapel').change(function() {
        const mapelId = $(this).val();
        const guruSelect = $('#quick-guru');
        
        guruSelect.empty().append('<option value="">Pilih Guru</option>');
        
        if (!mapelId) {
            guruSelect.html('<option value="">Pilih Mapel dahulu</option>');
            return;
        }
        
        guruSelect.html('<option value="">Memuat...</option>');
        
        fetchGuru(mapelId, function(guruData) {
            guruSelect.empty().append('<option value="">Pilih Guru</option>');
            guruData.forEach(function(guru) {
                guruSelect.append(`<option value="${guru.id}">${guru.nama}</option>`);
            });
            
            if (guruData.length === 1) {
                guruSelect.val(guruData[0].id);
            }
        });
    });

    // Cell selection for quick fill
    $('#jadwal-grid td.jadwal-cell').click(function(e) {
        if ($(e.target).is('select, input')) return;
        $(this).toggleClass('cell-selected');
        const index = $('#jadwal-grid td.jadwal-cell').index(this);
        if ($(this).hasClass('cell-selected')) {
            if (!selectedCells.includes(index)) selectedCells.push(index);
        } else {
            selectedCells = selectedCells.filter(i => i !== index);
        }
    });

    // Apply quick fill
    $('#apply-quick').click(function() {
        const mapelId = $('#quick-mapel').val();
        const guruId = $('#quick-guru').val();
        const ruangId = $('#quick-ruang').val();

        selectedCells.forEach(index => {
            const cell = $('#jadwal-grid td.jadwal-cell').eq(index);
            
            if (mapelId) {
                cell.find('.mapel-select').val(mapelId).trigger('change');
                
                // Set guru after delay to wait for dropdown to populate
                if (guruId) {
                    setTimeout(() => {
                        cell.find('.guru-select').val(guruId);
                    }, 200);
                }
            }
            if (ruangId) {
                cell.find('.ruang-select').val(ruangId);
            }
        });

        $('.cell-selected').removeClass('cell-selected');
        selectedCells = [];
    });

    // Clear all
    $('#clear-all').click(function() {
        if (confirm('Bersihkan semua jadwal?')) {
            $('select.mapel-select').val('').trigger('change');
            $('select.ruang-select').val('');
            $('.cell-selected').removeClass('cell-selected');
            selectedCells = [];
        }
    });

    // Submit form
    $('#generator-form').submit(function(e) {
        e.preventDefault();

        const kelasId = $('#kelas_id').val();
        if (!kelasId) {
            alert('Pilih kelas terlebih dahulu!');
            return;
        }

        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.jadwal.generator.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    window.location.href = '{{ route("admin.jadwal.index") }}';
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                const message = xhr.responseJSON?.message || 'Gagal menyimpan jadwal';
                let msg = message + '\n';
                for (let key in errors) {
                    msg += '- ' + errors[key].join('\n- ') + '\n';
                }
                alert(msg);
            }
        });
    });
});
</script>
@endpush
@endsection
