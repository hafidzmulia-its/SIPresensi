{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
  <div class="text-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
      {{ __('Masuk ke Akun Anda') }}
    </h1>
    <p class="text-sm text-gray-600 dark:text-gray-400">
      {{ __("Belum punya akun?") }}
      <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
        {{ __('Daftar di sini') }}
      </a>
    </p>
  </div>

  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    {{-- Username --}}
    <div>
      <x-input-label for="username" :value="__('Username')" />
      <x-text-input id="username"
                    name="username"
                    type="text"
                    :value="old('username')"
                    required autofocus
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div>
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password"
                    name="password"
                    type="password"
                    required autocomplete="current-password"
                    class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Remember Me --}}
    <div class="flex items-center">
      <input id="remember_me"
             type="checkbox"
             name="remember"
             class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
      <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Remember me') }}
      </label>
    </div>

    {{-- Forgot Password --}}
    @if (Route::has('password.request'))
      <div class="text-sm text-right">
        <a href="{{ route('password.request') }}"
           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
          {{ __('Lupa password?') }}
        </a>
      </div>
    @endif

    {{-- Submit --}}
    <div>
      <button type="submit"
              class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white font-medium rounded-md shadow transition transform hover:scale-105">
        {{ __('Masuk') }}
      </button>
    </div>
  </form>
</x-guest-layout>
