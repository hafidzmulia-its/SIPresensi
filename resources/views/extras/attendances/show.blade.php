<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __("Detail Presensi: {$report->extra->name}") }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
        <p><strong>{{ __('Tanggal:') }}</strong> {{ $report->date }}</p>
        <p><strong>{{ __('Berita Acara:') }}</strong> {{ $report->berita_acara }}</p>
        <p><strong>{{ __('Dikirim oleh:') }}</strong> {{ $report->reporter->name }}</p>
        <p><strong>{{ __('Status:') }}</strong>
          <span class="font-semibold">{{ ucfirst($report->status) }}</span>
        </p>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-4 py-2">{{ __('#') }}</th>
              <th class="px-4 py-2">{{ __('Nama') }}</th>
              <th class="px-4 py-2">{{ __('Status') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($report->details as $i => $d)
              <tr>
                <td class="px-4 py-2">{{ $i+1 }}</td>
                <td class="px-4 py-2">{{ $d->student->name }}</td>
                <td class="px-4 py-2">{{ ucfirst($d->presence) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
