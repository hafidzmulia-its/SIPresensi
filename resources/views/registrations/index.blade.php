<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pendaftaran Ekstrakurikuler') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($extras as $extra)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $extra->name }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ __('Pembina:') }} {{ $extra->pembina->name }}
                            </p>
                        </div>
                        <div class="mt-4">
                            @if(array_key_exists($extra->id, $userRegs))
                                @php
                                    // find the registration model id
                                    $reg = auth()->user()
                                                 ->extrasAsStudent()
                                                 ->wherePivot('extra_id', $extra->id)
                                                 ->first()
                                                 ->pivot
                                                 ->id;
                                @endphp
                                <form method="POST" action="{{ route('registrations.destroy', $reg) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex justify-center px-4 py-2 bg-red-600 dark:bg-red-500 hover:bg-red-700 dark:hover:bg-red-600 text-white font-semibold rounded-md">
                                        {{ __('Unregister') }}
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('registrations.store') }}">
                                    @csrf
                                    <input type="hidden" name="extra_id" value="{{ $extra->id }}">
                                    <button type="submit"
                                            class="w-full inline-flex justify-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-semibold rounded-md">
                                        {{ __('Register') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
