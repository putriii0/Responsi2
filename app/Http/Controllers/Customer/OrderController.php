<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->with(['items.product', 'shippings'])->latest()->get();
        return view('pages.customers.order.index', compact('orders'));
    }

    public function generateInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        $pdf = PDF::loadView('layouts.invoice', compact('order'));

        return $pdf->stream("invoice-order-{$order->id}.pdf");
    }

    public function received($id)
    {
        $order = Order::find($id);

        $order->status = "arrived";
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order berhasil diterima.');
    }
}
