<div class="space-y-4">
  <div>
    <h2 class="text-xl font-semibold text-gray-800">Kategori</h2>
    <ul class="space-y-2">
      <li>
        <a href="{{ route('products.index') }}" class="text-lg text-gray-700 hover:text-indigo-600">Semua Produk</a>
      </li>
      @foreach ($categories as $category)
        <li>
          <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-lg text-gray-700 hover:text-indigo-600">
            {{ $category->name }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</div>
