@extends('layouts.admin')
@section('title', 'Generator Jadwal')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Generator Jadwal</h1>
    <p class="text-gray-500">Buat jadwal dengan cepat untuk satu kelas</p>
</div>

@if(!$semester)
<div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
    <i class="fas fa-exclamation-triangle mr-2"></i>Belum ada semester aktif. Silakan set semester aktif terlebih dahulu.
</div>
@else
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form id="generator-form">
        @csrf
        <input type="hidden" name="semester_id" value="{{ $semester->id }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                <select name="kelas_id" id="kelas_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }} - {{ $k->jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durasi per Jam Pelajaran</label>
                <select name="durasi" id="durasi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="45">45 menit</option>
                    <option value="40">40 menit</option>
                    <option value="50">50 menit</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai_default" id="jam_mulai_default" value="07:00" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Jadwal Grid -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="border p-2 w-20">Jam Ke</th>
                        <th class="border p-2">Senin</th>
                        <th class="border p-2">Selasa</th>
                        <th class="border p-2">Rabu</th>
                        <th class="border p-2">Kamis</th>
                        <th class="border p-2">Jumat</th>
                        <th class="border p-2">Sabtu</th>
                    </tr>
                </thead>
                <tbody id="jadwal-grid">
                    @for($jam = 1; $jam <= 10; $jam++)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-2 text-center font-medium bg-gray-50">
                            <span class="jam-ke">{{ $jam }}</span>
                            <div class="text-xs text-gray-500 jam-waktu"></div>
                        </td>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                        <td class="border p-1">
                            <div class="grid grid-cols-1 gap-1">
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][mapel]" class="mapel-select w-full px-2 py-1 border rounded text-xs focus:ring-1 focus:ring-indigo-500">
                                    <option value="">-</option>
                                    @foreach($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->kode }}</option>
                                    @endforeach
                                </select>
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][guru]" class="guru-select w-full px-2 py-1 border rounded text-xs focus:ring-1 focus:ring-indigo-500">
                                    <option value="">Guru</option>
                                    @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ \Str::limit($g->nama, 15) }}</option>
                                    @endforeach
                                </select>
                                <select name="jadwal[{{ $jam }}][{{ $hari }}][ruang]" class="ruang-select w-full px-2 py-1 border rounded text-xs focus:ring-1 focus:ring-indigo-500">
                                    <option value="">Ruang</option>
                                    @foreach($ruang as $r)
                                    <option value="{{ $r->id }}">{{ $r->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                <i class="fas fa-save mr-2"></i>Simpan Jadwal
            </button>
            <button type="button" id="clear-all" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-eraser mr-2"></i>Bersihkan Semua
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>

<!-- Quick Fill Panel -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="font-semibold mb-4"><i class="fas fa-magic mr-2"></i>Quick Fill - Isi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <select id="quick-mapel" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Mapel</option>
                @foreach($mapel as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Guru</label>
            <select id="quick-guru" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Guru</option>
                @foreach($guru as $g)
                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ruang</label>
            <select id="quick-ruang" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Ruang</option>
                @foreach($ruang as $r)
                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" id="apply-quick" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-fill mr-2"></i>Terapkan ke Sel Terpilih
            </button>
        </div>
    </div>
    <p class="text-sm text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i>Klik sel untuk memilih, lalu klik "Terapkan" untuk mengisi otomatis</p>
</div>
@endif

@push('styles')
<style>
    .cell-selected { background-color: #e0e7ff !important; }
    .mapel-select:focus, .guru-select:focus, .ruang-select:focus { background-color: #fef3c7; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let selectedCells = [];

    // Update jam waktu
    function updateJamWaktu() {
        const durasi = parseInt($('#durasi').val());
        const jamMulai = $('#jam_mulai_default').val().split(':');
        let currentMinutes = parseInt(jamMulai[0]) * 60 + parseInt(jamMulai[1]);

        $('.jam-waktu').each(function(index) {
            const startHour = Math.floor(currentMinutes / 60);
            const startMin = currentMinutes % 60;
            const endMinutes = currentMinutes + durasi;
            const endHour = Math.floor(endMinutes / 60);
            const endMin = endMinutes % 60;

            $(this).text(
                String(startHour).padStart(2, '0') + ':' + String(startMin).padStart(2, '0') + ' - ' +
                String(endHour).padStart(2, '0') + ':' + String(endMin).padStart(2, '0')
            );
            currentMinutes = endMinutes;
        });
    }

    updateJamWaktu();
    $('#durasi, #jam_mulai_default').change(updateJamWaktu);

    // Cell selection for quick fill
    $('#jadwal-grid td:not(:first-child)').click(function(e) {
        if ($(e.target).is('select')) return;
        $(this).toggleClass('cell-selected');
        const index = $('#jadwal-grid td:not(:first-child)').index(this);
        if ($(this).hasClass('cell-selected')) {
            selectedCells.push(index);
        } else {
            selectedCells = selectedCells.filter(i => i !== index);
        }
    });

    // Apply quick fill
    $('#apply-quick').click(function() {
        const mapel = $('#quick-mapel').val();
        const guru = $('#quick-guru').val();
        const ruang = $('#quick-ruang').val();

        selectedCells.forEach(index => {
            const cell = $('#jadwal-grid td:not(:first-child)').eq(index);
            if (mapel) cell.find('.mapel-select').val(mapel);
            if (guru) cell.find('.guru-select').val(guru);
            if (ruang) cell.find('.ruang-select').val(ruang);
        });

        // Clear selection
        $('.cell-selected').removeClass('cell-selected');
        selectedCells = [];
    });

    // Clear all
    $('#clear-all').click(function() {
        if (confirm('Bersihkan semua jadwal?')) {
            $('select.mapel-select, select.guru-select, select.ruang-select').val('');
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
                let msg = 'Terjadi kesalahan:\n';
                for (let key in errors) {
                    msg += '- ' + errors[key].join('\n- ') + '\n';
                }
                alert(msg || 'Gagal menyimpan jadwal');
            }
        });
    });
});
</script>
@endpush
@endsection
