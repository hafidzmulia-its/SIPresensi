{{-- resources/views/extras/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Ekstrakurikuler') }}
            </h2>
            @can('view', App\Models\Extra::class)
                <a href="{{ route('extras.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-lg shadow">
                    <x-heroicon-o-plus class="h-5 w-5 mr-1"/> {{ __('Tambah Ekstra') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($extras->isEmpty())
                <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Belum ada ekstrakurikuler.') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($extras as $extra)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition">
                            <div class="p-6 flex flex-col h-full">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $extra->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <span class="font-medium">{{ __('Pembina:') }}</span>
                                    {{ $extra->pembina->name }}
                                </p>

                                <div class="mt-auto space-y-2">
                                    <a href="{{ route('extras.show', $extra) }}"
                                       class="block text-center py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-800 dark:text-gray-200">
                                        {{ __('Lihat Detail') }}
                                    </a>

                                    <div class="flex justify-between">
                                        @can('update', $extra)
                                            <a href="{{ route('extras.edit', $extra) }}"
                                               class="flex-1 text-center py-2 bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 rounded text-black dark:text-white mr-1">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan

                                        @can('delete', $extra)
                                            <form action="{{ route('extras.destroy', $extra) }}" method="POST" class="flex-1">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('{{ __('Hapus ekstra ini?') }}')"
                                                        class="w-full py-2 bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 rounded text-white">
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
