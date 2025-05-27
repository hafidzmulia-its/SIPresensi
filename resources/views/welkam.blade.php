{{-- resources/views/guest/index.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
  <title>{{ $title ?? 'Welcome' }}</title>
  <style>
    @keyframes zoom-in-out {
      0%,100% { transform: scale(1); }
      50%    { transform: scale(1.1); }
    }
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(1rem); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-zoom-in-out { animation: zoom-in-out 20s ease-in-out infinite; }
    .animate-fade-in    { animation: fade-in 1s ease-out forwards; }
  </style>
</head>
<body class="h-full overflow-hidden">
  <div class="relative h-screen w-screen text-white">
    {{-- Background --}}
    <div class="absolute inset-0 overflow-hidden">
      <img src="{{ asset('images/bg.jpg') }}"
           alt="Background"
           class="w-full h-full object-cover animate-zoom-in-out" />
      <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-4 animate-fade-in">
      {{-- Gradient Heading --}}
      <h1 class="text-5xl font-extrabold mb-4 bg-gradient-to-r from-pink-400 to-purple-500 bg-clip-text text-transparent">
        Welcome to SI Presensi
      </h1>
      <p class="text-lg text-gray-200 mb-8">
        Sistem Informasi Presensi Ekstrakurikuler Siswa<br/>SMAIT Al Uswah Surabaya
      </p>
      <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
        {{-- Teal-Cyan Button --}}
        <a href="{{ route('login') }}"
           class="inline-block py-3 px-8 rounded-full text-lg font-semibold 
                  bg-gradient-to-r from-teal-400 to-blue-500 text-black
                  hover:from-teal-500 hover:to-blue-600 transition transform hover:scale-105">
          Login
        </a>
        {{-- Coral-Orange Button --}}
        <a href="{{ route('register') }}"
           class="inline-block py-3 px-8 rounded-full text-lg font-semibold 
                  bg-gradient-to-r from-orange-400 to-red-400 text-black
                  hover:from-orange-500 hover:to-red-500 transition transform hover:scale-105">
          Register
        </a>
      </div>
    </div>
  </div>
</body>
</html>
