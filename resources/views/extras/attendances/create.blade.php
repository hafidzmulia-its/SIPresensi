<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __("Buat Presensi: {$extra->name}") }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <form method="POST" action="{{ route('extras.attendances.store', $extra) }}">
        @csrf

        <div class="mb-4">
          <x-input-label for="date" :value="__('Tanggal')" />
          <x-text-input id="date" name="date" type="date"
                        value="{{ old('date', now()->toDateString()) }}"
                        required class="block mt-1 w-full" />
          <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <div class="mb-4">
          <x-input-label for="berita_acara" :value="__('Berita Acara')" />
          <textarea id="berita_acara" name="berita_acara" rows="3"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md">
            {{ old('berita_acara') }}
          </textarea>
          <x-input-error :messages="$errors->get('berita_acara')" class="mt-2" />
        </div>

        <div class="mb-6">
          <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Daftar Anggota') }}
          </h3>
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('#') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Nama') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Status') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($members as $i => $member)
                    <tr>
                    <td class="px-4 py-2 text-gray-500 dark:text-gray-300">{{ $i+1 }}</td>
                    <td class="px-4 py-2 text-gray-500 dark:text-gray-300">{{ $member->name }}</td>
                    <td class="px-4 py-2 text-gray-500 dark:text-gray-300">
                        <input type="hidden" name="presence[{{ $i }}][student_id]" value="{{ $member->id }}">
                        <div class="flex space-x-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="presence[{{ $i }}][status]" value="hadir" required
                                class="hidden peer" {{ old("presence.$i.status", 'hadir') === 'hadir' ? 'checked' : '' }}>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-green-100 hover:text-green-800 dark:hover:bg-green-700 dark:hover:text-green-100 peer-checked:bg-green-600 peer-checked:text-white cursor-pointer">
                            {{ __('Hadir') }}
                            </span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="presence[{{ $i }}][status]" value="izin" required
                                class="hidden peer" {{ old("presence.$i.status") === 'izin' ? 'checked' : '' }}>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-yellow-100 hover:text-yellow-800 dark:hover:bg-yellow-700 dark:hover:text-yellow-100 peer-checked:bg-yellow-600 peer-checked:text-white cursor-pointer">
                            {{ __('Izin') }}
                            </span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="presence[{{ $i }}][status]" value="sakit" required
                                class="hidden peer" {{ old("presence.$i.status") === 'sakit' ? 'checked' : '' }}>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-blue-100 hover:text-blue-800 dark:hover:bg-blue-700 dark:hover:text-blue-100 peer-checked:bg-blue-600 peer-checked:text-white cursor-pointer">
                            {{ __('Sakit') }}
                            </span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="presence[{{ $i }}][status]" value="alfa" required
                                class="hidden peer" {{ old("presence.$i.status") === 'alfa' ? 'checked' : '' }}>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-red-100 hover:text-red-800 dark:hover:bg-red-700 dark:hover:text-red-100 peer-checked:bg-red-600 peer-checked:text-white cursor-pointer">
                            {{ __('Alfa') }}
                            </span>
                        </label>
                        </div>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            
          </table>
        </div>

        <button type="submit"
                class="px-4 py-2 bg-green-600 dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 text-white rounded-md">
          {{ __('Submit Laporan') }}
        </button>
      </form>
    </div>
  </div>
</x-app-layout>
