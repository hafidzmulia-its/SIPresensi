<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("Detail Ekstrakurikuler") }}
      </h2>

      @can('update', $extra)
        <a href="{{ route('extras.edit', $extra) }}"
           class="inline-flex items-center px-4 py-2 bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-black dark:text-white rounded-lg shadow">
          <x-heroicon-o-pencil class="h-5 w-5 mr-1" />
          {{ __('Edit') }}
        </a>
      @endcan
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- Informasi Ekstrakurikuler --}}
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-800 dark:text-gray-100">
        <h3 class="text-lg font-bold mb-4">{{ $extra->name }}</h3>
        <p><strong>{{ __('Pembina:') }}</strong> {{ $extra->pembina->name }}</p>
        <p><strong>{{ __('Tahun Ajaran:') }}</strong> {{ date('Y') }}</p>
      </div>

      {{-- Daftar Anggota --}}
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
          <h4 class="font-semibold text-gray-800 dark:text-gray-100">{{ __('Daftar Anggota') }}</h4>
        </div>

        @if($extra->anggota->isEmpty())
          <div class="p-4 text-gray-500 dark:text-gray-400 text-sm">
            {{ __('Belum ada anggota terdaftar pada tahun ini.') }}
          </div>
        @else
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Nama') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @foreach($extra->anggota as $i => $user)
                <tr>
                  <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      {{-- Tombol Laporan Presensi --}}
      <div class="text-right">
        <a href="{{ route('extras.attendances.index', $extra) }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
          <x-heroicon-o-document-text class="h-5 w-5 mr-1" />
          {{ __('Lihat Laporan Presensi') }}
        </a>
      </div>

    </div>
  </div>
</x-app-layout>
