@extends('layouts.dashboard')

@section('title', 'Dashboard | Pesanan | Teska')

@section('content')
<div class="max-w-screen-xl px-6 py-8 mx-auto sm:px-8 sm:py-12 lg:px-10">
    <div class="px-4 sm:px-0">
        <h3 class="text-xl font-semibold leading-8 text-indigo-900">Detail Pesanan</h3>
        <p class="mt-2 text-sm text-gray-600">Informasi pelanggan dan detail pesanan.</p>
    </div>
    <div class="mt-6 border-t border-gray-200">
        <dl class="divide-y divide-gray-200">
            <!-- Nama Pelanggan -->
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:px-0">
                <dt class="text-sm font-medium text-gray-800">Nama Pelanggan</dt>
                <dd class="mt-1 text-base text-gray-700 sm:col-span-2 sm:mt-0">{{ $order->user->name }}</dd>
            </div>

            <!-- Alamat Pelanggan -->
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:px-0">
                <dt class="text-sm font-medium text-gray-800">Alamat Pelanggan</dt>
                <dd class="mt-1 text-base text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $order->shipping_address }}
                </dd>
            </div>

            <!-- List Produk -->
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:px-0">
                <dt class="text-sm font-medium text-gray-800">Produk yang Dibeli</dt>
                <dd class="mt-1 text-base text-gray-700 sm:col-span-2 sm:mt-0">
                    <ul role="list" class="space-y-3">
                        @foreach ($order->items as $item)
                        <li class="flex justify-between items-center">
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="object-cover w-14 h-14 rounded-lg shadow-md">
                                <span class="text-sm font-medium text-gray-800">{{ $item->product->name }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                        <li class="flex justify-between items-center font-semibold text-lg text-gray-900">
                            <p class="text-sm">
                                Total
                                @if($order->user->subscription_status == 1)
                                <span class="text-xs text-gray-500">(Sudah Dipotong Diskon Member)</span>
                                @endif
                            </p>
                            <span class="text-lg">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </dd>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:px-0">
                <dt class="text-sm font-medium text-gray-800">Bukti Pembayaran</dt>
                <dd class="mt-1 text-base text-indigo-600 sm:col-span-2 sm:mt-0">
                    <a href="{{ asset('storage/' . $order->payment->receipt_image) }}" class="text-indigo-600 hover:text-indigo-800 underline" download="">Lihat Bukti Pembayaran</a>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Form Input Nomor Resi -->
    <div class="mt-6 bg-gray-50 p-6 rounded-lg shadow-md">
        <form action="{{ route('dashboard.orders.send', $order->id) }}" method="POST">
            @csrf
            <div class="mb-4 flex flex-col gap-3 lg:flex-row items-center">
                <label for="tracking_number" class="block text-sm font-medium text-gray-800">Nomor Resi :</label>
                <input type="text" name="tracking_number" id="tracking_number" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 sm:text-sm px-4 py-2 max-w-3xl bg-slate-300">
                @if($errors->has('tracking_number'))
                    <span class="mt-2 text-sm text-red-600"> {{ $errors->first('tracking_number') }}</span>
                @endif
            </div>
            <div class="flex justify-end space-x-6">
                <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-indigo-700 border border-transparent rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    Kirim No Resi
                </button>
            </div>
        </form>
    </div>

    <!-- Form Tolak Pemesanan -->
    <div class="mt-6 bg-red-50 p-6 rounded-lg shadow-md">
        <form action="{{ route('dashboard.orders.reject', $order->id) }}" method="POST">
            @csrf
            <div class="flex justify-end space-x-6">
                <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-red-700 border border-transparent rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                    Tolak Pemesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
