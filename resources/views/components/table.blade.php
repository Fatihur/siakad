@props(['title', 'createRoute' => null, 'createText' => 'Tambah', 'useDataTable' => true])

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-4 sm:p-6 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="font-semibold text-gray-800">{{ $title }}</h2>
        @if($createRoute)
        <a href="{{ $createRoute }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i>{{ $createText }}
        </a>
        @endif
    </div>
    <div class="p-4 sm:p-6">
        <div class="overflow-x-auto">
            <table class="w-full {{ $useDataTable ? 'datatable' : '' }}" style="width:100%">
                <thead class="bg-gray-50">
                    {{ $header }}
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
