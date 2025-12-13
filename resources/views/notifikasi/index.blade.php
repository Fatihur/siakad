@extends('layouts.' . auth()->user()->role)
@section('title', 'Notifikasi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        <p class="text-gray-500">Semua notifikasi Anda</p>
    </div>
    @if($notifikasi->where('dibaca_pada', null)->count() > 0)
    <form action="{{ route('notifikasi.baca-semua') }}" method="POST">
        @csrf
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
        </button>
    </form>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm">
    @if($notifikasi->count() > 0)
    <div class="divide-y">
        @foreach($notifikasi as $n)
        <div class="p-4 flex items-start gap-4 {{ !$n->dibaca_pada ? 'bg-indigo-50' : '' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                @if($n->tipe == 'success') bg-green-100 text-green-600
                @elseif($n->tipe == 'warning') bg-yellow-100 text-yellow-600
                @elseif($n->tipe == 'danger') bg-red-100 text-red-600
                @else bg-blue-100 text-blue-600 @endif">
                <i class="fas 
                    @if($n->tipe == 'success') fa-check
                    @elseif($n->tipe == 'warning') fa-exclamation
                    @elseif($n->tipe == 'danger') fa-times
                    @else fa-bell @endif"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="font-medium text-gray-800">{{ $n->judul }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $n->pesan }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $n->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if(!$n->dibaca_pada)
                        <form action="{{ route('notifikasi.baca', $n) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-sm" title="Tandai dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                        @if($n->link)
                        <a href="{{ route('notifikasi.baca', $n) }}" class="text-indigo-600 hover:text-indigo-800 text-sm" title="Lihat">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        @endif
                        <form action="{{ route('notifikasi.hapus', $n) }}" method="POST" onsubmit="return confirm('Hapus notifikasi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="p-4 border-t">
        {{ $notifikasi->links() }}
    </div>
    @else
    <div class="p-8 text-center text-gray-500">
        <i class="fas fa-bell-slash text-4xl mb-3"></i>
        <p>Tidak ada notifikasi</p>
    </div>
    @endif
</div>
@endsection
