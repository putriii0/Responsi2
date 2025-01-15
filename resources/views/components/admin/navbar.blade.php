<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="container flex items-center justify-between px-4 py-5 mx-auto">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="/" class="text-xl font-semibold text-gray-800">
                Blirrdmo
            </a>
        </div>

        <!-- Toggle Menu (Layar Kecil) -->
        <button id="menuToggle" class="text-gray-700 lg:hidden hover:text-gray-900 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <!-- Menu -->
        <div id="menu" class="items-center hidden space-x-8 lg:flex">
            <a href="{{ route('dashboard.index') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
            <a href="{{ route('dashboard.products.index') }}" class="text-gray-700 hover:text-gray-900">Produk</a>
            <a href="{{ route('dashboard.orders.index') }}" class="text-gray-700 hover:text-gray-900">Pesanan</a>
            <a href="{{ route('dashboard.users.index') }}" class="text-gray-700 hover:text-gray-900">Pengguna</a>
        </div>

        <!-- Icons -->
        <div class="flex items-center space-x-6">
            <!-- Jika pengguna sudah login -->
            @auth
                <!-- User/Profile Icon -->
                <div class="relative">
                    <button id="userMenuButton" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="account" class="w-7 h-7" fill="currentColor">
                            <path d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"></path>
                        </svg>
                    </button>
                    <!-- Dropdown -->
                    <div id="userDropdown" class="absolute right-0 z-10 hidden w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                        <!-- <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Profile
                        </a> -->
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Keluar
                        </a>
                    </div>
                </div>
            @else
                <!-- Jika pengguna belum login -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="font-semibold text-gray-700 hover:text-gray-900">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="font-semibold text-gray-500 hover:text-gray-700">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Dropdown Menu (Layar Kecil) -->
    <div id="dropdownMenu" class="hidden bg-white shadow-md lg:hidden">
        <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('dashboard.products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Produk</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pesanan</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pengguna</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kontak</a>
    </div>
</nav>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('menuToggle');
        const menu = document.getElementById('menu');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');

        // Toggle menu pada layar kecil
        menuToggle.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Dropdown user menu
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            // Tutup user dropdown jika klik di luar
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }

            // Tutup menu dropdown jika klik di luar
            if (!menuToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>