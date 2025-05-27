<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($extra) ? __('Edit Ekstrakurikuler') : __('Tambah Ekstrakurikuler') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST"
                          action="{{ isset($extra) ? route('extras.update', $extra) : route('extras.store') }}">
                        @csrf
                        @isset($extra) @method('PUT') @endisset

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Ekstra')" />
                            <x-text-input id="name" name="name"
                                          type="text"
                                          value="{{ old('name', $extra->name ?? '') }}"
                                          required autofocus
                                          class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pembina_id" :value="__('Pembina')" />
                            <select id="pembina_id" name="pembina_id" required
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @foreach($pembinas as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('pembina_id', $extra->pembina_id ?? '') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pembina_id')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full inline-flex justify-center px-4 py-2 bg-green-600 dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 text-white font-semibold rounded-md">
                                {{ isset($extra) ? __('Update') : __('Simpan') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
