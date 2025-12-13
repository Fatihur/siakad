@props(['title', 'createRoute' => null, 'createText' => 'Tambah', 'useDataTable' => true])

<div class="card">
    <div class="px-6 py-4 border-b border-stroke flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-semibold text-[#1C2434]">{{ $title }}</h3>
        @if($createRoute)
        <a href="{{ $createRoute }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span>{{ $createText }}</span>
        </a>
        @endif
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full {{ $useDataTable ? 'datatable' : '' }}" style="width:100%">
                <thead>
                    {{ $header }}
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
