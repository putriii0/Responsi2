<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // // Ambil produk dari kategori "new" menggunakan relasi category()
        // $newProducts = Product::whereHas('category', fn($query) => $query->where('name', 'new'))->take(4)->get();
    
        // // Return ke view dengan compact
        // return view('pages.customers.home.index', compact('newProducts'));

        // Ambil 4 produk terbaru
        $newProducts = Product::orderBy('created_at', 'desc')->take(4)->get();

        // Ambil 4 produk yang paling sering dibeli berdasarkan jumlah kemunculannya di order_items
        $popularProducts = Product::select('products.id', 'products.name', 'products.price', 'products.category_id', 'products.stock_quantity', 'products.image', 'products.slug', 'products.created_at', 'products.updated_at')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.category_id', 'products.stock_quantity', 'products.image', 'products.slug', 'products.created_at', 'products.updated_at')
            ->orderByDesc('total_quantity') // Urutkan berdasarkan jumlah total quantity yang terjual
            ->take(4) // Ambil 4 produk teratas
            ->get();

        // Kirim data ke view
        return view('pages.customers.home.index', compact('newProducts', 'popularProducts'));
    }
}
