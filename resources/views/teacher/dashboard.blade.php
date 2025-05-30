{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Dashboard') }}
      </h2>
      <p class="text-sm text-gray-600 dark:text-gray-400">
        {{ __('Anda masuk sebagai') }} <span class="font-medium">{{ ucfirst($user->role) }}</span>
      </p>
    </div>
  </x-slot>

  <div class="py-6 space-y-8 px-4 sm:px-6 lg:px-8">

    {{-- Overview --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">
        {{ __('Overview') }}
    </h3>

    @if($extras->isEmpty())
        <p class="text-gray-700 dark:text-gray-300">{{ __('You are not managing any extracurricular activities.') }}</p>
    @else
        @foreach($extras as $extra)
            <div class="grid grid-cols-1 gap-4 my-12 overflow-x-auto bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                <div class=" space-y-4">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $extra->name }}
                    </h4>

                    <div class="flex justify-between divide-x divide-gray-300 dark:divide-gray-600">
                        {{-- Approved --}}
                        <div class="text-center flex-1 px-4">
                            <div class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">
                                {{ __('Approved') }}
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $extra->reports->where('status', 'approved')->count() }}
                            </div>
                        </div>
                        {{-- Pending --}}
                        <div class="text-center flex-1 px-4">
                            <div class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase">
                                {{ __('Pending') }}
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $extra->reports->where('status', 'pending')->count() }}
                            </div>
                        </div>
                        {{-- Rejected --}}
                        <div class="text-center flex-1 px-4">
                            <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                                {{ __('Rejected') }}
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $extra->reports->where('status', 'rejected')->count() }}
                            </div>
                        </div>
                        {{-- Total Reports --}}
                        <div class="text-center flex-1 px-4">
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                {{ __('Total') }}
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $extra->reports->count() }}
                            </div>
                        </div>
                    </div>

                    {{-- Button to View Attendance --}}
                    <div class="text-right mt-4">
                        <a href="{{ route('extras.attendances.index', $extra->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-semibold rounded-md shadow">
                            {{ __('View Attendance') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>


    {{-- Pending Submissions --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 overflow-x-auto">
      <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">
        {{ __('Pending Submissions') }}
      </h3>

      @if($pendingReports->isEmpty())
        <p class="text-gray-700 dark:text-gray-300">{{ __('No pending submissions at this time.') }}</p>
      @else
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              @if($user->role === 'admin')
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                  {{ __('Ekstrakurikuler') }}
                </th>
              @else
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
              @endif
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Tanggal') }}</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Reporter') }}</th>
              <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Action') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($pendingReports as $idx => $report)
              <tr class="{{ ($loop->iteration +1) % 2 ? 'bg-gray-50 dark:bg-gray-700' : '' }}">
                @if($user->role === 'admin')
                  <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $report->extra->name }}</td>
                @else
                  <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                @endif
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                  {{ \Illuminate\Support\Carbon::parse($report->date)->translatedFormat('l, d F Y') }}
                </td>
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $report->reporter->name }}</td>
                <td class="px-4 py-2 text-right">
                  <a href="{{ route('attendances.show', $report) }}"
                     class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    {{ __('Review') }}
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

    {{-- Student Performance (only for pembina) --}}
    @if($user->role === 'pembina')
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 overflow-x-auto">
        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">
          {{ __('Student Performance') }}
        </h3>

        @if($students->isEmpty())
          <p class="text-gray-700 dark:text-gray-300">{{ __('No students found.') }}</p>
        @else
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Name') }}</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Hadir') }}</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Izin') }}</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Sakit') }}</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ __('Alfa') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @foreach($students as $student)
                <tr>
                  <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $student->name }}</td>
                  <td class="px-4 py-2 text-center text-green-600 dark:text-green-400 font-semibold">{{ $student->hadir }}</td>
                  <td class="px-4 py-2 text-center text-yellow-600 dark:text-yellow-400 font-semibold">{{ $student->izin }}</td>
                  <td class="px-4 py-2 text-center text-blue-600 dark:text-blue-400 font-semibold">{{ $student->sakit }}</td>
                  <td class="px-4 py-2 text-center text-red-600 dark:text-red-400 font-semibold">{{ $student->alfa }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    @endif

  </div>
</x-app-layout>

