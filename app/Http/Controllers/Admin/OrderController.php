<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shipping;

class OrderController extends Controller
{
    public function index()
    {
        // Mengambil order dengan shipping_address yang tidak null
        $pendingOrders = Order::whereNotNull('shipping_address')->where('status', 'pending')->with(['user', 'items', 'payment'])->latest()->paginate(10);

        $orders = Order::whereNotNull('shipping_address')->where('status', '!=', 'pending')->with(['user', 'items', 'payment'])->latest()->paginate(10);

        // Mengembalikan tampilan dengan data order
        return view('pages.admin.order.index', compact('pendingOrders', 'orders'));
    }

    public function manage($id) {
        $order = Order::where('id', $id)->with(['user', 'items', 'payment'])->first();

        return view('pages.admin.order.manage', compact('order'));
    }

    public function send(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tracking_number' => 'required|string',
        ], [
            'tracking_number.required' => 'Nomor Resi harus diisi.',
        ]);

        $order = Order::findOrFail($id);

        $order->status = 'delivered';
        $order->save();

        $payment = Payment::where('order_id', $order->id)->first();

        $payment->payment_status = 'paid';
        $payment->save();

        $products = $order->items;

        foreach ($products as $product) {
            $prd = Product::where('id', $product->product_id)->first();
            $prd->stock_quantity -= $product->quantity;
            $prd->save();
        }

        $shipping = new Shipping();
        $shipping->order_id = $order->id;
        $shipping->tracking_number = $validatedData['tracking_number'];
        $shipping->save();

        return redirect()->route('dashboard.orders.index')->with('success', 'Order berhasil dikirim.');
    }

    public function reject($id)
    {
        $order = Order::find($id);

        $order->status = "rejected";
        $order->save();

        return redirect()->route('dashboard.orders.index')->with('success', 'Order berhasil ditolak.');
    }

}
