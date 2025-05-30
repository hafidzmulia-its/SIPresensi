<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __("Presensi: {$extra->name}") }}
    </h2>
  </x-slot>

  <div class="py-6 mx-4">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
      <a href="{{ route('extras.attendances.create', $extra) }}"
         class="inline-block px-4 py-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md"
         >
        + {{ __('Buat Laporan Presensi') }}
      </a>
      <div class="grid grid-cols-1 gap-6">
          
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Rangkuman Presensi Ekstrakurikuler') }}
        </h4>
    </div>

    @if(auth()->user()->role === 'student')
        {{-- Student Summary --}}
        <div class="grid grid-cols-4 md:grid-cols-5 gap-4">
            <div class="text-center">
                <div class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">
                    {{ __('Hadir') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $summary['hadir'] }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase">
                    {{ __('Izin') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $summary['izin'] }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase">
                    {{ __('Sakit') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $summary['sakit'] }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                    {{ __('Alfa') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $summary['alfa'] }}
                </div>
            </div>
            <div class="flex flex-col items-center col-span-4 md:col-span-1 border-gray-300 dark:border-gray-600 pl-4 cursor-pointer">
                <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                    {{ __('Total Pertemuan') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $summary['meetings'] }}
                </div>
            </div>
        </div>
    @else
        {{-- Admin/Pembina Summary --}}
        <div class="grid grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">
                    {{ __('Approved') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $extra->reports->where('status', 'approved')->count() }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase">
                    {{ __('Pending') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $extra->reports->where('status', 'pending')->count() }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                    {{ __('Rejected') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $extra->reports->where('status', 'rejected')->count() }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                    {{ __('Total Reports') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $extra->reports->count() }}
                </div>
            </div>
        </div>
    @endif
</div>

        </div>

      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto ">
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
                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $idx + 1 }}</td>
                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ \Illuminate\Support\Carbon::parse($r->date)->translatedFormat('l, d F Y')}}</td>
                <td class="px-6 py-4">
                  <span class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $r->status === 'approved' ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100' : ($r->status==='rejected' ? 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-100' : 'bg-yellow-100 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100') }}">
                    {{ ucfirst($r->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <a href="{{ route('attendances.show', $r) }}"
                     class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Lihat') }}</a>
                   @can('update', $r)
                    @if(auth()->user()->role === 'pembina' || auth()->user()->role === 'admin')
                        <a href="{{ route('attendances.edit', $r) }}"
                           class="text-yellow-600 dark:text-yellow-400 hover:underline">{{ __('Approve') }}</a>
                    @else
                        <a href="{{ route('attendances.edit', $r) }}"
                           class="text-yellow-600 dark:text-yellow-400 hover:underline">{{ __('Edit') }}</a>
                    @endif
                  @endcan
                  @can('delete', $r)
                      <form method="POST" action="{{ route('attendances.destroy', $r) }}" class="inline">
                          @csrf @method('DELETE')
                          <button type="submit"
                                  onclick="return confirm('{{ __('Yakin ingin menghapus laporan ini?') }}')"
                                  class="text-red-600 dark:text-red-400 hover:underline">
                              {{ __('Hapus') }}
                          </button>
                      </form>
                  @endcan
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
