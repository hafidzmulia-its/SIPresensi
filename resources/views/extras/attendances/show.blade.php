{{-- resources/views/extras/attendances/show.blade.php --}}

<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("Detail Presensi: {$report->extra->name}") }}
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

  <div class="py-6 mx-4">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
      {{-- Report Info --}}
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
            <p>{{ $report->berita_acara ?? '-' }}</p>
          </div>
          <div class="md:col-span-2 ">
            <p class="font-semibold">{{ __('Status') }}</p>
            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold
              {{ $report->status === 'approved' 
                  ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100' 
                  : ($report->status === 'rejected' 
                      ? 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-100' 
                      : 'bg-yellow-100 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100') }}">
              {{ ucfirst($report->status) }}
            </span>
          </div>

          {{-- Summary Info --}}
         

        <div class="md:col-span-2 grid grid-cols-4 md:grid-cols-5 gap-4 md:gap-2 px-4 ">
          <div class="cursor-pointer">
              <div class="text-sm font-semibold text-green-600 dark:text-green-400 uppercase">{{ __('Hadir') }}</div>
              <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $report->details->where('presence', 'hadir')->count() }}</span>
          </div>
          <div class="border-l border-gray-300 dark:border-gray-600 pl-4 cursor-pointer">
              <div class="text-sm font-semibold text-yellow-600 dark:text-yellow-400 uppercase">{{ __('Izin') }}</div>
              <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $report->details->where('presence', 'izin')->count() }}</span>
          </div>
          <div class="border-l border-gray-300 dark:border-gray-600 pl-4 cursor-pointer">
              <div class="text-sm font-semibold text-blue-600 dark:text-blue-400 uppercase">{{ __('Sakit') }}</div>
              <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $report->details->where('presence', 'sakit')->count() }}</span>
          </div>
          <div class="border-l border-gray-300 dark:border-gray-600 pl-4 cursor-pointer">
              <div class="text-sm font-semibold text-red-600 dark:text-red-400 uppercase">{{ __('Alfa') }}</div>
              <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $report->details->where('presence', 'alfa')->count() }}</span>
          </div>
          @if(in_array($report->status, ['approved', 'pending']))
          <div class="flex flex-col items-center col-span-4 md:col-span-1 border-gray-300 dark:border-gray-600 pl-4 cursor-pointer">
    <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">{{ __('Pertemuan Ke') }}</div>
    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $meetingIndex }}</span>
    </div>
          @endif
        </div>      
      </div>

      {{-- Report Notes --}}


      {{-- Documentation Image --}}
      @if($report->image_path)
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
          <p class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('Dokumentasi') }}</p>
          <img src="{{ asset('storage/' . $report->image_path) }}"
               alt="Dokumentasi Presensi"
               class="w-full rounded-lg shadow-md object-contain max-h-60" />
        </div>
      @endif

      {{-- Attendance Details --}}
      <div class="bg-white dark:bg-gray-800  sm:rounded-lg p-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Nama Siswa') }}</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Kehadiran') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($report->details as $i => $detail)
              <tr>
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $i + 1 }}</td>
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $detail->student->name }}</td>
                <td class="px-4 py-2">
                  @php $p = $detail->presence; @endphp
                  <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $p === 'hadir' 
                        ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100' 
                        : ($p === 'izin' 
                            ? 'bg-yellow-100 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100' 
                            : ($p === 'alfa' 
                                ? 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-100' 
                                : 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-100')) }}">
                    {{ ucfirst($p) }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Actions --}}
      <div class="flex justify-end space-x-4">
        @can('generatePdf', $report)
          <a href="{{ route('attendances.pdf', $report) }}"
            class="inline-flex items-center px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg shadow">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v8m4-4H8m4-9a9 9 0 100 18 9 9 0 000-18z" />
            </svg>
            {{ __('Download PDF') }}
          </a>
        @endcan
        @can('approve', $report)
          @if($report->status === 'pending')
            <a href="{{ route('attendances.edit', $report) }}"
               class="inline-flex items-center px-6 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg shadow">
              {{ __('Approve / Reject') }}
            </a>
          @endif
        @endcan
      </div>
    </div>
  </div>
</x-app-layout>
