@props(['title', 'action', 'method' => 'POST', 'backRoute', 'hasFile' => false])

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-4 sm:p-6 border-b">
        <h2 class="font-semibold text-gray-800">{{ $title }}</h2>
    </div>
    <form action="{{ $action }}" method="POST" {{ $hasFile ? 'enctype=multipart/form-data' : '' }} class="p-4 sm:p-6">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif
        <div class="space-y-4">
            {{ $slot }}
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-center">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="{{ $backRoute }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>
