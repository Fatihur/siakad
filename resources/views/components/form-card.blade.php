@props(['title', 'action', 'method' => 'POST', 'backRoute' => null, 'hasFile' => false])

<div class="card max-w-3xl">
    <div class="px-6 py-4 border-b border-stroke">
        <h3 class="font-semibold text-[#1C2434]">{{ $title }}</h3>
    </div>
    <form action="{{ $action }}" method="POST" {!! $hasFile ? 'enctype="multipart/form-data"' : '' !!}>
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif
        <div class="p-6 space-y-5">
            {{ $slot }}
        </div>
        <div class="px-6 py-4 bg-[#F9FAFB] border-t border-stroke flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan</span>
            </button>
            @if($backRoute)
            <a href="{{ $backRoute }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            @endif
        </div>
    </form>
</div>
