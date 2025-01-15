<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto flex items-center justify-between px-4 py-5">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="/" class="text-xl font-semibold text-gray-800">
                Blirrdmo
            </a>
        </div>

        <!-- Menu Button (Mobile) -->
        <div class="lg:hidden">
            <button id="menuButton" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="black">
                    <path fill-rule="evenodd" d="M4 6h16M4 12h16M4 18h16" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <!-- Menu (Desktop) -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="/" class="text-gray-700 hover:text-gray-900">Home</a>
            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900">Shop</a>
            <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-gray-900">My Order</a>
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
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Profile
                        </a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Keluar
                        </a>
                    </div>
                </div>

                <!-- Cart Icon -->
                <div class="relative">
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-gray-900 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 200 200" id="cart" fill="currentColor">
                            <path d="M75 71.09v-10c0-14.28 11.15-25.93 25-25.93s25 11.65 25 25.93v10h17.28A3.13 3.13 0 0 1 145.4 74l5.94 87.5a3.14 3.14 0 0 1-2.91 3.33H51.78a3.12 3.12 0 0 1-3.12-3.12v-.21L54.6 74a3.13 3.13 0 0 1 3.12-2.92Zm9.38 0h31.25v-10c0-9.19-7-16.56-15.63-16.56S84.38 51.9 84.38 61.09Zm-25.91 84.38h83.06l-5.08-75H63.56Z"></path>
                        </svg>
                    </a>
                </div>
            @else
                <!-- Jika pengguna belum login -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-pink-500 hover:text-pink-700 font-semibold">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="lg:hidden hidden bg-white shadow-md">
        <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
        <a href="{{ route('products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Shop</a>
        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Order</a>
    </div>
</nav>

<!-- Script for Dropdown and Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        // Toggle user dropdown
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        // Toggle mobile menu
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!menuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
