<aside class="bg-white w-1/5 min-h-full p-6 flex flex-col items-center fixed h-full">
  <!-- Logo -->
  <div class="mb-8">
      <img src="{{ asset('Logo.jpg') }}" alt="Logo" class="w-50">
      <h2 class="text-2xl font-semibold text-gray-700">⸻⸻⸻⸻⸻</h2>
  </div>
  <!-- Sidebar Menu -->
  <ul class="w-full">
    <ul class="w-full">
      <li class="mb-4">
          <a href="{{ route('dashboard') }}" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z" />
              </svg>
              Dashboard
          </a>
      </li>
      <!-- Pembuatan Ruang (BA role) -->
      @if($user->ba == 1)
          <li class="mb-4">
              <a href="{{ route('ruang') }}" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Pembuatan Ruang
              </a>
          </li>
          <li class="mb-4">
              <a href="{{ route('plotruang') }}" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Daftar Ruang
              </a>
          </li>
      @endif

      <!-- Kaprodi Menu (KP role) -->
      @if($user->kp == 1)
          <li class="mb-4">
              <a href="{{ route('matakuliah') }}" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Buat Mata Kuliah
              </a>
          </li>
          <li class="mb-4">
              <a href="{{ route('buatjadwal') }}" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Buat Jadwal
              </a>
          </li>
      @endif

      <!-- Dekan Menu (DK role) -->
      @if($user->dk == 1)
          <li class="mb-4">
              <button onclick="location.href='{{ route('ajuanjadwal') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Verifikasi Jadwal
              </button>
          </li>
          <li class="mb-4">
              <button onclick="location.href='{{ route('ajuanruang') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Verifikasi Ruang Kelas
              </button>
          </li>
      @endif

      <!-- Pembimbing Akademik (PA role) -->
      @if($user->pa == 1)
          <li class="mb-4">
              <button onclick="location.href='{{ route('perwalian.list') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Perwalian
              </button>
          </li>
      @endif

      <!-- Mahasiswa (Mahasiswa role) -->
      @if($user->mhs == 1)
          <li class="mb-4">
              <button onclick="location.href='{{ route('mahasiswa.registrasi') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Registrasi
              </button>
          </li>
          <li class="mb-4">
              <button onclick="location.href='{{ route('mahasiswa.irs') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Akademik
              </button>
          </li>
          <li class="mb-4">
              <button onclick="location.href='{{ route('mahasiswa.jadwal') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                  </svg>
                  Jadwal Kuliah
              </button>
          </li>
      @endif
      
      
  </ul>
</aside>



    <script>
      const sidebar = document.getElementById('sidebar');

      if (sidebar) {
          const toggleSidebarMobile = (sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose) => {
              sidebar.classList.toggle('hidden');
              sidebarBackdrop.classList.toggle('hidden');
              toggleSidebarMobileHamburger.classList.toggle('hidden');
              toggleSidebarMobileClose.classList.toggle('hidden');
          }
          
          const toggleSidebarMobileEl = document.getElementById('toggleSidebarMobile');
          const sidebarBackdrop = document.getElementById('sidebarBackdrop');
          const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
          const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');
          const toggleSidebarMobileSearch = document.getElementById('toggleSidebarMobileSearch');
          
          toggleSidebarMobileSearch.addEventListener('click', () => {
              toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
          });
          
          toggleSidebarMobileEl.addEventListener('click', () => {
              toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
          });
          
          sidebarBackdrop.addEventListener('click', () => {
              toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
          });
      }
    </script>
</aside>