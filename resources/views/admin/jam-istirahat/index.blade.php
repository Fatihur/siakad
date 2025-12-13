@extends('layouts.admin')
@section('title', 'Jam Istirahat')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1C2434]">Jam Istirahat</h2>
    <p class="text-[#64748B]">Atur waktu istirahat dalam jadwal pelajaran</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="card">
        <div class="px-6 py-4 border-b border-stroke">
            <h3 class="font-semibold text-[#1C2434]">Tambah Jam Istirahat</h3>
        </div>
        <form action="{{ route('admin.jam-istirahat.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="form-label">Nama <span class="text-meta-1">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', 'Istirahat') }}" required 
                    class="form-input" placeholder="Contoh: Istirahat 1">
            </div>
            <div>
                <label class="form-label">Setelah Jam Ke <span class="text-meta-1">*</span></label>
                <select name="setelah_jam_ke" required class="form-input form-select">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('setelah_jam_ke') == $i ? 'selected' : '' }}>Jam ke-{{ $i }}</option>
                    @endfor
                </select>
                <p class="text-xs text-[#64748B] mt-1">Istirahat akan disisipkan setelah jam pelajaran ini</p>
            </div>
            <div>
                <label class="form-label">Durasi (menit) <span class="text-meta-1">*</span></label>
                <input type="number" name="durasi_menit" value="{{ old('durasi_menit', 15) }}" required min="5" max="60"
                    class="form-input" placeholder="15">
            </div>
            <button type="submit" class="btn btn-primary w-full">
                <i class="fas fa-plus"></i>
                <span>Tambah</span>
            </button>
        </form>
    </div>

    <!-- Daftar Jam Istirahat -->
    <div class="lg:col-span-2 card">
        <div class="px-6 py-4 border-b border-stroke">
            <h3 class="font-semibold text-[#1C2434]">Daftar Jam Istirahat</h3>
        </div>
        <div class="p-6">
            @if($data->count() > 0)
            <div class="space-y-3">
                @foreach($data as $item)
                <div class="flex items-center justify-between p-4 rounded-lg border border-stroke {{ $item->aktif ? 'bg-white' : 'bg-[#F9FAFB]' }}">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg {{ $item->aktif ? 'bg-warning/20' : 'bg-[#E2E8F0]' }} flex items-center justify-center">
                            <i class="fas fa-coffee {{ $item->aktif ? 'text-warning' : 'text-[#9CA3AF]' }} text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-[#1C2434] {{ !$item->aktif ? 'line-through opacity-50' : '' }}">{{ $item->nama }}</h4>
                            <p class="text-sm text-[#64748B]">
                                Setelah jam ke-{{ $item->setelah_jam_ke }} &bull; {{ $item->durasi_menit }} menit
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.jam-istirahat.toggle', $item) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg transition-colors {{ $item->aktif ? 'text-meta-3 hover:bg-meta-3/10' : 'text-[#9CA3AF] hover:bg-[#F1F5F9]' }}" title="{{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fas {{ $item->aktif ? 'fa-toggle-on text-xl' : 'fa-toggle-off text-xl' }}"></i>
                            </button>
                        </form>
                        <button type="button" onclick="editIstirahat({{ $item->id }}, '{{ $item->nama }}', {{ $item->setelah_jam_ke }}, {{ $item->durasi_menit }})" 
                            class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.jam-istirahat.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus jam istirahat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-[#64748B] hover:text-meta-1 hover:bg-[#FEF2F2] rounded-lg transition-colors" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 rounded-full bg-[#F1F5F9] flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-coffee text-2xl text-[#9CA3AF]"></i>
                </div>
                <p class="text-[#64748B]">Belum ada jam istirahat</p>
                <p class="text-sm text-[#9CA3AF]">Tambahkan jam istirahat untuk ditampilkan di jadwal</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="card">
            <div class="px-6 py-4 border-b border-stroke flex items-center justify-between">
                <h3 class="font-semibold text-[#1C2434]">Edit Jam Istirahat</h3>
                <button type="button" onclick="closeModal()" class="text-[#64748B] hover:text-[#1C2434]">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="form-edit" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="form-label">Nama <span class="text-meta-1">*</span></label>
                    <input type="text" name="nama" id="edit-nama" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Setelah Jam Ke <span class="text-meta-1">*</span></label>
                    <select name="setelah_jam_ke" id="edit-setelah-jam" required class="form-input form-select">
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">Jam ke-{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label">Durasi (menit) <span class="text-meta-1">*</span></label>
                    <input type="number" name="durasi_menit" id="edit-durasi" required min="5" max="60" class="form-input">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fas fa-save"></i>
                        <span>Simpan</span>
                    </button>
                    <button type="button" onclick="closeModal()" class="btn btn-outline">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editIstirahat(id, nama, setelahJam, durasi) {
    $('#form-edit').attr('action', '/admin/jam-istirahat/' + id);
    $('#edit-nama').val(nama);
    $('#edit-setelah-jam').val(setelahJam);
    $('#edit-durasi').val(durasi);
    $('#modal-edit').removeClass('hidden');
}

function closeModal() {
    $('#modal-edit').addClass('hidden');
}
</script>
@endpush
@endsection
