<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // dd("hi");
        $products = Product::with('category')->paginate(10);
        
        return view('pages.admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.admin.product.create', compact('categories'));
    }
    

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'new_category.string' => 'Kategori baru harus berupa teks.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format file gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 10 MB.',
        ]);

        // Validasi tambahan: Tidak boleh mengisi keduanya sekaligus
        if ($request->filled('category_id') && $request->filled('new_category')) {
            return redirect()->back()
                ->withErrors([
                    'new_category' => 'Pilih salah satu: kategori yang sudah ada atau kategori baru.'
                ])
                ->withInput();
        }
        
        // Tambahkan kategori baru jika diinput
        if ($request->filled('new_category')) {
            $category = Category::create(['name' => $request->new_category]);
            $validatedData['category_id'] = $category->id;
        }
    
        // Proses upload file gambar jika ada
        if ($request->hasFile('image')) {
            // $fileName = $request->file('image')->hashName();
            // dd($request->file('image'));
            // $request->file('image')->storeAs('public/products', $fileName);
            // $validatedData['image'] = $fileName;
            // $fileName = $request->file('image')->storeAs('products', 'public');
            // $validatedData['image'] = $fileName;
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $fileName, 'public');
            $validatedData['image'] = $fileName;
        }

        // Buat slug dari nama produk
        $validatedData['slug'] = Str::slug($validatedData['name']);
    
        // Simpan data ke dalam database
        Product::create($validatedData);
    
        // Redirect dengan pesan sukses
        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
        
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        return view('pages.admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'new_category.string' => 'Kategori baru harus berupa teks.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format file gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 10 MB.',
        ]);
    
        // Temukan produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();
    
        // Validasi tambahan: Tidak boleh mengisi keduanya (kategori lama & baru) sekaligus
        if ($request->filled('category_id') && $request->filled('new_category')) {
            return redirect()->back()
                ->withErrors(['new_category' => 'Pilih salah satu: kategori yang sudah ada atau kategori baru.'])
                ->withInput();
        }
    
        // Tambahkan kategori baru jika diinput
        if ($request->filled('new_category')) {
            $category = Category::create(['name' => $request->new_category]);
            $validatedData['category_id'] = $category->id;
        }
    
        // Perbarui data produk
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->category_id = $validatedData['category_id'] ?? $product->category_id;
        $product->stock_quantity = $validatedData['stock_quantity'];
    
        // Perbarui file gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
    
            // Simpan gambar baru
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $fileName, 'public');
            $product->image = $fileName;
        }
    
        // Perbarui slug jika nama produk diubah
        if ($product->isDirty('name')) {
            $product->slug = Str::slug($validatedData['name']);
        }
    
        // Simpan perubahan
        $product->save();
    
        // Redirect dengan pesan sukses
        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Pastikan untuk mengecek apakah produk memiliki file gambar sebelum menghapus
        if ($product->image) {
            $imagePath = storage_path('app/public/products/' . $product->image);

            // Cek apakah file gambar benar-benar ada, lalu hapus
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus data produk dari database
        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
