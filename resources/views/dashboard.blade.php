
<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Selamat datang,') }} {{ $user->name }}!
      </h2>
      <p class="mt-1 sm:mt-0 text-sm text-gray-600 dark:text-gray-300">
        {{ __('Anda login sebagai') }} <span class="font-medium">{{ ucfirst($user->role) }}</span>.
      </p>
    </div>
  </x-slot>

  <div class="py-6 space-y-8 px-4">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">
        {{ __('Ekstrakurikuler Anda') }}
      </h3>

      @if($summaries->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center text-gray-500 dark:text-gray-400">
          {{ __('Belum ada ekstrakurikuler.') }}
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @foreach($summaries as $sum)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
              <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                  {{ $sum['extra']->name }}
                </h4>
                <a href="{{ route('extras.attendances.index', $sum['extra']) }}"
                   class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                  {{ __('Laporan Presensi') }}
                </a>
              </div>

              <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <div class="text-center">
                  <div class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">
                    {{ __('Hadir') }}
                  </div>
                  <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $sum['hadir'] }}
                  </div>
                </div>
                <div class="text-center">
                  <div class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase">
                    {{ __('Izin') }}
                  </div>
                  <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $sum['izin'] }}
                  </div>
                </div>
                <div class="text-center">
                  <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase">
                    {{ __('Sakit') }}
                  </div>
                  <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $sum['sakit'] }}
                  </div>
                </div>
                <div class="text-center">
                  <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                    {{ __('Alfa') }}
                  </div>
                  <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $sum['alfa'] }}
                  </div>
                </div>
                <div class="text-center">
                  <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                    {{ __('Pertemuan') }}
                  </div>
                  <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $sum['meetings'] }}
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
