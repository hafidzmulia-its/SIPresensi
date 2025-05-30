{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
  <div class="text-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
      {{ __('Daftar Akun Baru') }}
    </h1>
    <p class="text-sm text-gray-600 dark:text-gray-400">
      {{ __("Silakan isi data Anda untuk membuat akun.") }}
    </p>
  </div>

  <form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    {{-- Name --}}
    <div>
      <x-input-label for="name" :value="__('Nama Lengkap')" />
      <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Username --}}
    <div>
      <x-input-label for="username" :value="__('Username')" />
      <x-text-input id="username" name="username" type="text" :value="old('username')" required
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    {{-- Email --}}
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" :value="old('email')" required
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div>
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" name="password" type="password" required
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Confirm Password --}}
    <div>
      <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
      <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    {{-- Submit --}}
    <div class="flex items-center justify-between">
      <a href="{{ route('login') }}"
         class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
        {{ __('Sudah punya akun? Masuk di sini') }}
      </a>

      <button type="submit"
              class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white font-medium rounded-md shadow transition transform hover:scale-105">
        {{ __('Daftar') }}
      </button>
    </div>
  </form>
</x-guest-layout>
