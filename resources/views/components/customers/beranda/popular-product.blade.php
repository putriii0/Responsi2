<section class="max-w-screen-xl px-4 py-8 mx-auto sm:px-6 sm:py-12 lg:px-8">
  <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Produk Populer</h2>

  <!-- Daftar Produk Baru -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    @foreach ($popularProducts as $product)
    <div class="bg-white border border-gray-200 shadow-md overflow-hidden">
      <!-- Gambar Produk -->
      <div class="relative">
        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" 
             class="w-full h-72 object-cover">
      </div>

      <!-- Info Produk -->
      <div class="p-4">
        <h3 class="font-semibold text-lg text-gray-900 truncate">{{ $product->name }}</h3>
        <p class="text-gray-700 mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
        <div class="mt-4">
          <!-- Tombol Beli Sekarang -->
          <a 
            href="{{ route('checkout.buy_now', $product->slug) }}" 
            class="block text-center text-white bg-gray-600 hover:bg-gray-800 px-4 py-2 rounded mb-2"
          >
            Beli Sekarang
          </a>
          <!-- Tombol Tambahkan ke Keranjang -->
          <form action="{{ route('cart.store', $product->slug) }}" method="POST">
            @csrf
            <button 
              type="submit" 
              class="block w-full text-center text-white bg-gray-700 hover:bg-gray-800 px-4 py-2 rounded"
            >
              Tambahkan ke Keranjang
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Tautan ke Semua Produk -->
  <div class="flex justify-center mt-8">
    <a 
      href="{{ route('products.index') }}" 
      class="text-gray-500 hover:text-gray-700 font-semibold text-lg"
    >
      Lihat Semua Produk
    </a>
  </div>
</section>
