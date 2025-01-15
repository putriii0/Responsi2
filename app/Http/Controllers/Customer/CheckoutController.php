<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->with('product')->get();
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total_price = 0;
        foreach ($carts as $cart) {
            $price_after_discount = ($cart->product->price - ($cart->product->price * $cart->product->discount / 100));
            $total_price += $price_after_discount * $cart->quantity;
        }

        return view('pages.customers.checkout.index', compact('carts', 'total_price'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_name' => 'required|string|max:255',
            'order_phone' => 'required|string|max:15',
            'alamat' => 'required|string',
            'detail-alamat' => 'nullable|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode-pos' => 'required|integer',
            'bukti-pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10024',
        ], [
            'order_name.required' => 'Nama pemesan harus diisi.',
            'order_phone.required' => 'Nomor telepon harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'kota.required' => 'Kota harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kode-pos.required' => 'Kode pos harus diisi.',
            'bukti-pembayaran.required' => 'Bukti pembayaran harus diupload.',
        ]);
    
        $validatedData['alamat'] = implode(', ', array_filter([
            $validatedData['alamat'],
            $request->input('detail-alamat'),
            $validatedData['kota'],
            $validatedData['provinsi'],
            $validatedData['kode-pos'],
        ]));
    
        if ($request->hasFile('bukti-pembayaran')) {
            $file = $request->file('bukti-pembayaran');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
            $validatedData['bukti_pembayaran'] = str_replace('public/', '', $filePath);
        }
    
        $carts = Cart::where('user_id', auth()->user()->id)->with('product')->get();
    
        $total_price = 0;
        foreach ($carts as $cart) {
            $price = $cart->product->price; // Harga murni produk
            $total_price += $price * $cart->quantity;
        }
    
        // Buat Order
        $orders = new Order();
        $orders->user_id = auth()->user()->id;
        $orders->total_price = $total_price;
        $orders->shipping_address = $validatedData['alamat'];
        $orders->order_name = $validatedData['order_name'];
        $orders->order_phone = $validatedData['order_phone'];
        $orders->status = 'pending';
        $orders->save();
    
        // Buat Order Items
        foreach ($carts as $cart) {
            $order_items = new OrderItem();
            $order_items->order_id = $orders->id;
            $order_items->product_id = $cart->product->id;
            $order_items->quantity = $cart->quantity;
            $order_items->price = $cart->product->price; // Harga murni produk
            $order_items->total = $order_items->price * $order_items->quantity;
            $order_items->save();
        }
    
        // Simpan Bukti Pembayaran
        $payment = new Payment();
        $payment->order_id = $orders->id;
        $payment->receipt_image = $validatedData['bukti_pembayaran'];
        $payment->payment_status = 'pending';
        $payment->transactions_date = now();
        $payment->save();
    
        // Hapus Keranjang
        Cart::where('user_id', auth()->user()->id)->delete();
    
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirimkan.');
    }    
    
    public function buy_now($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('pages.customers.checkout.buy-now', compact('product'));
    }

    public function buy_now_store(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'order_name' => 'required|string|max:255',
            'kode-pos' => 'required|integer',
            'order_phone' => 'required|string|max:15',
            'alamat' => 'required|string',
            'detail-alamat' => 'nullable|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode-pos' => 'required|integer',
            'bukti-pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10024',
        ], [
            'order_name.required' => 'Nama pemesan harus diisi.',
            'order_phone.required' => 'Nomor telepon harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'kota.required' => 'Kota harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kode-pos.required' => 'Kode pos harus diisi.',
            'bukti-pembayaran.required' => 'Bukti pembayaran harus diupload.',
        ]);
    
        $product = Product::where('slug', $slug)->firstOrFail();
    
        $validatedData['alamat'] = implode(', ', array_filter([
            $validatedData['alamat'],
            $request->input('detail-alamat'),
            $validatedData['kota'],
            $validatedData['provinsi'],
            $validatedData['kode-pos'],
        ]));
    
        if ($request->hasFile('bukti-pembayaran')) {
            $file = $request->file('bukti-pembayaran');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
            $validatedData['bukti_pembayaran'] = str_replace('public/', '', $filePath);
        }
    
        // Buat Order
        $orders = new Order();
        $orders->user_id = auth()->user()->id;
        $orders->total_price = $product->price; // Harga produk langsung
        $orders->shipping_address = $validatedData['alamat'];
        $orders->order_name = $validatedData['order_name'];
        $orders->order_phone = $validatedData['order_phone'];
        $orders->status = 'pending';
        $orders->save();
    
        // Buat Order Items
        $order_items = new OrderItem();
        $order_items->order_id = $orders->id;
        $order_items->product_id = $product->id;
        $order_items->quantity = 1; // Jumlah 1 untuk Buy Now
        $order_items->price = $product->price; // Harga produk langsung
        $order_items->total = $order_items->price * $order_items->quantity;
        $order_items->save();
    
        // Simpan Bukti Pembayaran
        $payment = new Payment();
        $payment->order_id = $orders->id;
        $payment->receipt_image = $validatedData['bukti_pembayaran'];
        $payment->payment_status = 'pending';
        $payment->transactions_date = now();
        $payment->save();
    
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirimkan.');
    }    
}
