@extends('layouts.' . auth()->user()->role)
@section('title', 'Notifikasi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-[#1C2434]">Notifikasi</h2>
        <p class="text-[#64748B]">Semua notifikasi Anda</p>
    </div>
    @if($notifikasi->where('dibaca_pada', null)->count() > 0)
    <form action="{{ route('notifikasi.baca-semua') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check-double"></i>
            <span>Tandai Semua Dibaca</span>
        </button>
    </form>
    @endif
</div>

<div class="card">
    @if($notifikasi->count() > 0)
    <div class="divide-y divide-stroke">
        @foreach($notifikasi as $n)
        @php
            $colors = [
                'success' => ['bg-[#ECFDF3]', 'text-meta-3', 'fa-check'],
                'warning' => ['bg-[#FEF9C3]', 'text-meta-6', 'fa-exclamation'],
                'danger' => ['bg-[#FEF2F2]', 'text-meta-1', 'fa-times'],
                'info' => ['bg-[#E0F2FE]', 'text-meta-5', 'fa-bell'],
            ];
            $c = $colors[$n->tipe] ?? $colors['info'];
        @endphp
        <div class="p-5 flex items-start gap-4 hover:bg-[#F9FAFB] transition-colors {{ !$n->dibaca_pada ? 'bg-[#EFF4FB]/50' : '' }}">
            <div class="w-11 h-11 {{ $c[0] }} rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas {{ $c[2] }} {{ $c[1] }}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-[#1C2434]">{{ $n->judul }}</p>
                            @if(!$n->dibaca_pada)
                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                            @endif
                        </div>
                        <p class="text-sm text-[#64748B] mt-1">{{ $n->pesan }}</p>
                        <p class="text-xs text-[#9CA3AF] mt-2">
                            <i class="fas fa-clock mr-1"></i>{{ $n->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center gap-1 flex-shrink-0">
                        @if(!$n->dibaca_pada)
                        <form action="{{ route('notifikasi.baca', $n) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Tandai dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                        @if($n->link)
                        <a href="{{ route('notifikasi.baca', $n) }}" class="p-2 text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] rounded-lg transition-colors" title="Lihat">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        @endif
                        <form action="{{ route('notifikasi.hapus', $n) }}" method="POST" onsubmit="return confirm('Hapus notifikasi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-[#64748B] hover:text-meta-1 hover:bg-[#FEF2F2] rounded-lg transition-colors" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="p-4 border-t border-stroke">
        {{ $notifikasi->links() }}
    </div>
    @else
    <div class="p-12 text-center">
        <div class="w-20 h-20 bg-[#F9FAFB] rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-bell-slash text-3xl text-[#9CA3AF]"></i>
        </div>
        <h3 class="font-semibold text-[#1C2434] mb-1">Tidak ada notifikasi</h3>
        <p class="text-[#64748B]">Anda tidak memiliki notifikasi saat ini</p>
    </div>
    @endif
</div>
@endsection
