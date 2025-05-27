{{-- resources/views/extras/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Ekstrakurikuler') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">{{ __('Semua Ekstrakurikuler') }}</h3>
                        @can('create', App\Models\Extra::class)
                            <a href="{{ route('extras.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-md">
                                + {{ __('Tambah Ekstra') }}
                            </a>
                        @endcan
                    </div>
                    smkmaskdma
                    <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                          <thead class="bg-gray-50 dark:bg-gray-700">
                              <tr>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                      {{ __('Nama') }}
                                  </th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                      {{ __('Pembina') }}
                                  </th>
                                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                      {{ __('Aksi') }}
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                              @foreach($extras as $extra)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                          {{ $extra->name }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                          {{ $extra->pembina->name }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                          <a href="{{ route('extras.show', $extra) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:underline">
                                              {{ __('Lihat') }}
                                          </a>
                                          @can('update', $extra)
                                              <a href="{{ route('extras.edit', $extra) }}"
                                                class="text-yellow-600 dark:text-yellow-400 hover:underline">
                                                  {{ __('Edit') }}
                                              </a>
                                          @endcan
                                          @can('delete', $extra)
                                              <form action="{{ route('extras.destroy', $extra) }}"
                                                    method="POST" class="inline">
                                                  @csrf @method('DELETE')
                                                  <button type="submit"
                                                          onclick="return confirm('{{ __('Hapus ekstra ini?') }}')"
                                                          class="text-red-600 dark:text-red-400 hover:underline">
                                                      {{ __('Hapus') }}
                                                  </button>
                                              </form>
                                          @endcan
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                   

                </div>
            </div>
        </div>
    </div>
</x-app-layout>