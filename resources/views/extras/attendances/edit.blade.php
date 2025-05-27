{{-- resources/views/extras/attendances/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("Ubah Presensi: {$report->extra->name}") }}
      </h2>
      <a href="{{ route('extras.attendances.index', $report->extra) }}"
         class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg shadow">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 mr-1"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>
        {{ __('Kembali') }}
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
      {{-- Report Metadata --}}
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-900 dark:text-gray-100">
          <div>
            <p class="font-semibold">{{ __('Tanggal') }}</p>
            <p>{{ \Illuminate\Support\Carbon::parse($report->date)->translatedFormat('d F Y') }}</p>
          </div>
          <div>
            <p class="font-semibold">{{ __('Dibuat Oleh') }}</p>
            <p>{{ $report->reporter->name }}</p>
          </div>
          <div class="md:col-span-2">
            <p class="font-semibold">{{ __('Berita Acara') }}</p>
            <p>{{ $report->berita_acara }}</p>
          </div>
          @if($report->image_path)
            <div class="md:col-span-2">
              <p class="font-semibold">{{ __('Dokumentasi') }}</p>
              <img src="{{ asset('storage/'.$report->image_path) }}"
                   alt="Dokumentasi"
                   class="w-full rounded-lg shadow-sm mt-2 object-contain" />
            </div>
          @endif
        </div>
      </div>

      {{-- Attendance Details --}}
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
              <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Nama Siswa') }}</th>
              <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Kehadiran') }}</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($report->details as $i => $detail)
              <tr class="bg-white dark:bg-gray-800">
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $i + 1 }}</td>
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $detail->student->name }}</td>
                @php $p = $detail->presence; @endphp
                <td class="px-4 py-2">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $p==='hadir' ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100'
                      : ($p==='izin' ? 'bg-yellow-100 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100'
                      : 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-100') }}">
                    {{ ucfirst($p) }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Approval Form --}}
      @can('approve', $report)
        <form method="POST" action="{{ route('attendances.update', $report) }}"
              class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
          @csrf @method('PUT')

          <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" required
                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
              <option value="approved" {{ $report->status==='approved' ? 'selected' : '' }}>{{ __('Approve') }}</option>
              <option value="rejected" {{ $report->status==='rejected' ? 'selected' : '' }}>{{ __('Reject') }}</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
          </div>

          <div class="flex justify-end space-x-4">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg shadow">
              {{ __('Simpan Status') }}
            </button>
          </div>
        </form>
      @endcan

      {{-- Delete Button --}}
      @canany(['delete'], [$report])
        @if(auth()->user()->role==='admin'
             || auth()->user()->role==='pembina'
             || (auth()->user()->role==='student' && in_array($report->status, ['pending','rejected'])))
          <form method="POST"
                action="{{ route('attendances.destroy', $report) }}"
                class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            @csrf @method('DELETE')
            <button type="submit"
                    onclick="return confirm('{{ __('Yakin ingin menghapus laporan ini?') }}')"
                    class="w-full inline-flex justify-center px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow">
              {{ __('Hapus Laporan') }}
            </button>
          </form>
        @endif
      @endcanany

    </div>
  </div>
</x-app-layout>
