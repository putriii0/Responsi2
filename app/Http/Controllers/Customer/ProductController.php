<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::with('category')->paginate(8);
        
    //     return view('pages.customers.product.index', compact('products'));
    // }
    
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Cek apakah ada filter kategori
        $categoryFilter = $request->get('category');
        $selectedCategory = null;
    
        if ($categoryFilter) {
            // Ambil kategori yang dipilih
            $selectedCategory = Category::find($categoryFilter);
            $products = Product::where('category_id', $categoryFilter)->paginate(8);
        } else {
            // Tampilkan semua produk jika tidak ada filter kategori
            $products = Product::paginate(8);
        }
    
        return view('pages.customers.product.index', compact('categories', 'products', 'selectedCategory'));
    }
     
}
