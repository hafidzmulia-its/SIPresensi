<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __("Approve Presensi: {$report->extra->name}") }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-md mx-auto sm:px-6 lg:px-8">
      <form method="POST" action="{{ route('attendances.update', $report) }}">
        @csrf @method('PUT')

        <div class="mb-4">
          <x-input-label for="status" :value="__('Status')" />
          <select id="status" name="status" required
                  class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            <option value="approved" {{ $report->status==='approved' ? 'selected' : '' }}>
              {{ __('Approve') }}
            </option>
            <option value="rejected" {{ $report->status==='rejected' ? 'selected' : '' }}>
              {{ __('Reject') }}
            </option>
          </select>
          <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <button type="submit"
                class="w-full px-4 py-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md">
          {{ __('Update Status') }}
        </button>
      </form>
    </div>
  </div>
</x-app-layout>
