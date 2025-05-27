<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __("Presensi: {$extra->name}") }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
      <a href="{{ route('extras.attendances.create', $extra) }}"
         @can('create', App\Models\AttendanceReport::class)
         class="inline-block px-4 py-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md"
         @endcan>
        + {{ __('Buat Laporan Presensi') }}
      </a>

      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Tanggal') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Status') }}</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Aksi') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($reports as $idx => $r)
              <tr>
                <td class="px-6 py-4">{{ $idx + 1 }}</td>
                <td class="px-6 py-4">{{ $r->date}}</td>
                <td class="px-6 py-4">
                  <span class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $r->status === 'approved' ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100' : ($r->status==='rejected' ? 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-100' : 'bg-yellow-100 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100') }}">
                    {{ ucfirst($r->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <a href="{{ route('attendances.show', $r) }}"
                     class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Lihat') }}</a>
                  @can('approve', $r)
                    <a href="{{ route('attendances.edit', $r) }}"
                       class="text-yellow-600 dark:text-yellow-400 hover:underline">{{ __('Approve') }}</a>
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                  {{ __('Belum ada laporan presensi.') }}
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>
