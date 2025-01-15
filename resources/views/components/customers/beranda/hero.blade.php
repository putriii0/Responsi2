<!-- Hero Section -->
<section class="relative">
    <!-- Background Image -->
    <img src="{{ asset('images/beranda/hero.jpg') }}" alt="Beautiful Bouquets" class="w-full h-[300px] sm:h-[400px] lg:h-[500px] object-cover">

    <!-- Overlay Content -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="container px-6 mx-auto">
            <!-- Text Content -->
            <div class="max-w-lg p-6 bg-white bg-opacity-80 rounded-lg shadow-lg">
                <h1 class="mb-4 text-3xl font-bold text-blue-900 sm:text-4xl lg:text-5xl">
                    Blirrdmo
                </h1>
                <p class="mb-6 text-base text-gray-800 sm:text-lg lg:text-xl">
                    Main billiard jadi lebih seru dengan meja premium dan aksesoris lengkap! Pilihan sempurna untuk ruang rekreasi Anda.
                </p>
                <!-- Button -->
                <a href="{{ route('products.index') }}" class="px-6 py-3 text-base font-semibold text-white transition duration-300 bg-gray-500 rounded-lg shadow-md hover:bg-gray-600">
                    Beli Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
