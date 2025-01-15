<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  @foreach ($products as $product)
  <div class="bg-white border border-gray-200 shadow-md overflow-hidden">
    <!-- Container Gambar Produk -->
    <div class="relative group">
      <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" 
           class="w-full h-72 object-cover transition-shadow duration-300 group-hover:shadow-lg">
      
      <!-- Tombol yang Muncul Saat Hover -->
      <div class="absolute inset-0 bg-white bg-opacity-50 flex flex-col items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
        <form action="{{ route('cart.store', $product->slug) }}" method="POST" class="mb-2">
          @csrf
          <button 
            type="submit" 
            class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 rounded"
          >
            Tambah ke Keranjang
          </button>
        </form>
        <a 
          href="{{ route('checkout.buy_now', $product->slug) }}" 
          class="px-4 py-2 text-sm font-medium text-white bg-gray-600 hover:bg-gray-800 rounded"
        >
          Beli Sekarang
        </a>
      </div>
    </div>
    
    <!-- Info Produk -->
    <div class="p-4">
      <h3 class="font-semibold text-lg text-gray-900 truncate">{{ $product->name }}</h3>
      <p class="text-gray-700 mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
    </div>
  </div>
  @endforeach
</div>
