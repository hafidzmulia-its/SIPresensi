<footer class=" border-t border-gray-200 dark:border-gray-700 py-6 bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
    <div class="text-center md:text-left">
      <p>&copy; {{ now()->year }} SMA IT Al Uswah. All rights reserved.</p>
      <p class="text-xs text-gray-400 dark:text-gray-500">SIPresensi System v1.0</p>
    </div>
    
    <div class="flex space-x-4 text-gray-500 dark:text-gray-400">
      <a href="{{ route('dashboard') }}" class="hover:text-gray-900 dark:hover:text-white">Dashboard</a>
      <a href="#" class="hover:text-gray-900 dark:hover:text-white">Dokumentasi</a>
      <a href="#" class="hover:text-gray-900 dark:hover:text-white">Kontak</a>
    </div>
  </div>
</footer>
