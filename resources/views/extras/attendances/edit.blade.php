<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("Ubah Presensi: {$report->extra->name}") }}
      </h2>
      <a href="{{ route('extras.attendances.index', $report->extra) }}"
         class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg shadow">
        <x-heroicon-o-arrow-left class="h-5 w-5 mr-1" />
        {{ __('Kembali') }}
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <form method="POST" action="{{ route('attendances.update', $report) }}" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Metadata --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <x-input-label for="date" :value="__('Tanggal')" />
            <x-text-input id="date" name="date" type="date" :value="old('date', $report->date)" required class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
          </div>
          <div>
            <p class="font-semibold">{{ __('Dibuat Oleh') }}</p>
            <p class="text-gray-700 dark:text-gray-300">{{ $report->reporter->name }}</p>
          </div>
          <div class="md:col-span-2">
            <x-input-label for="berita_acara" :value="__('Berita Acara')" />
            <textarea id="berita_acara" name="berita_acara" rows="3"
                      class="block mt-1 w-full rounded-md dark:bg-gray-700 dark:text-white">{{ old('berita_acara', $report->berita_acara) }}</textarea>
            <x-input-error :messages="$errors->get('berita_acara')" class="mt-2" />
          </div>
          <div class="md:col-span-2">
            <x-input-label for="image" :value="__('Dokumentasi (Opsional)')" />
            <input id="image" name="image" type="file"
                   class="block w-full text-sm text-gray-900 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer" />
            @if($report->image_path)
              <div class="mt-2">
                <img src="{{ asset('storage/'.$report->image_path) }}" alt="Dokumentasi"
                     class="w-full rounded-lg shadow object-contain max-h-64" />
              </div>
            @endif
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
          </div>
        </div>

        {{-- Editable Table --}}
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Nama Siswa') }}</th>
                <th class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Kehadiran') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
              @foreach($report->details as $i => $detail)
                <tr>
                  <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $detail->student->name }}</td>
                  <td class="px-4 py-2 ">
                    <select name="presence[{{ $detail->id }}]" required
                            class="rounded-md w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                      @foreach(['hadir', 'izin', 'alfa'] as $status)
                        <option value="{{ $status }}" {{ $detail->presence === $status ? 'selected' : '' }}>
                          {{ ucfirst($status) }}
                        </option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        
     

        {{-- Status (If Authorized) --}}
        @can('approve', $report)
          <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" required
                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
              <option value="approved" {{ $report->status==='approved' ? 'selected' : '' }}>{{ __('Approve') }}</option>
              <option value="rejected" {{ $report->status==='rejected' ? 'selected' : '' }}>{{ __('Reject') }}</option>
              <option value="pending" {{ $report->status==='pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
          </div>
        @endcan

        <div class="flex justify-between">
          <button type="submit"
                  class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
            {{ __('Simpan Perubahan') }}
          </button>
        </div>
      </form>

      {{-- Delete --}}
      @canany(['delete'], [$report])
        @if(auth()->user()->role==='admin'
            || auth()->user()->role==='pembina'
            || (auth()->user()->role==='student' && in_array($report->status, ['pending','rejected'])))
          <form method="POST" action="{{ route('attendances.destroy', $report) }}"
                class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mt-4">
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

