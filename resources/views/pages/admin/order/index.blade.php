@extends('layouts.dashboard')

@section('title', 'Dashboard | Pesanan | Teska')

@section('content')
{{-- Header --}}
<header class="bg-white border-b">
  <div class="max-w-screen-xl px-4 py-6 mx-auto sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold sm:text-3xl">Pesanan Produk</h1>
      <p class="text-sm text-gray-500">Kelola semua informasi terkait pesanan di sini.</p>
    </div>
  </div>
</header>

<section class="max-w-screen-xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
  {{-- Pesanan Pending --}}
  <div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-700 sm:text-2xl">Pesanan Pending</h2>
    <div class="mt-4 border border-gray-200 rounded-lg shadow bg-white">
      <div class="overflow-x-auto rounded-t-lg">
        <table class="min-w-full text-sm bg-gray-50 divide-y divide-gray-200">
          <thead class="bg-slate-900">
            <tr>
              <th class="px-4 py-2 font-medium text-center text-white">No</th>
              <th class="px-4 py-2 font-medium text-center text-white">Nama Pelanggan</th>
              <th class="px-4 py-2 font-medium text-center text-white">No. Order</th>
              <th class="px-4 py-2 font-medium text-center text-white">Harga</th>
              <th class="px-4 py-2 font-medium text-center text-white">Status</th>
              <th class="px-4 py-2 font-medium text-center text-white">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            @forelse ($pendingOrders as $order)
              <tr>
                <td class="px-4 py-2 text-center text-gray-700">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 text-center text-gray-900">{{ $order->user->name }}</td>
                <td class="px-4 py-2 text-center text-gray-700">#{{ $order->id }}</td>
                <td class="px-4 py-2 text-center text-gray-700">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-4 py-2 text-center text-gray-700">
                  <span class="inline-block px-2 py-1 text-xs font-medium text-white bg-yellow-500 rounded">
                  {{ $order->status }}
                  </span>
                </td>
                <td class="px-4 py-2 text-center">
                  <a href="{{ route('dashboard.orders.manage', $order->id) }}" class="inline-block p-2 bg-slate-100 rounded hover:bg-slate-200">
                    <i class='bx bx-edit text-xl'></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-2 text-center text-gray-700">Tidak ada pesanan pending.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{-- Pagination --}}
      <div class="flex justify-center px-4 py-3 bg-gray-50">
        {{ $pendingOrders->links('vendor.pagination.custom', ['item' => $pendingOrders]) }}
      </div>
    </div>
  </div>

  {{-- Semua Pesanan --}}
  <div>
    <h2 class="text-xl font-semibold text-gray-700 sm:text-2xl">Semua Pesanan</h2>
    <div class="mt-4 border border-gray-200 rounded-lg shadow bg-white">
      <div class="overflow-x-auto rounded-t-lg">
        <table class="min-w-full text-sm bg-gray-50 divide-y divide-gray-200">
          <thead class="bg-gray-700">
            <tr>
              <th class="px-4 py-2 font-medium text-center text-white">No</th>
              <th class="px-4 py-2 font-medium text-center text-white">Nama Pelanggan</th>
              <th class="px-4 py-2 font-medium text-center text-white">Harga</th>
              <th class="px-4 py-2 font-medium text-center text-white">Status</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            @forelse ($orders as $order)
              <tr>
                <td class="px-4 py-2 text-center text-gray-700">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 text-center text-gray-900">{{ $order->user->name }}</td>
                <td class="px-4 py-2 text-center text-gray-700">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-4 py-2 text-center text-gray-700">
                  @php
                      $statusBadge = [
                          'delivered' => 'bg-green-500',
                          'arrived' => 'bg-blue-500',
                          'completed' => 'bg-gray-500',
                          'rejected' => 'bg-red-500',
                      ];
                  @endphp
                  <span class="inline-block px-2 py-1 text-xs font-medium text-white {{ $statusBadge[$order->status] ?? 'bg-gray-400' }} rounded">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-2 text-center text-gray-700">Tidak ada pesanan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{-- Pagination --}}
      <div class="flex justify-center px-4 py-3 bg-gray-50">
        {{ $orders->links('vendor.pagination.custom', ['item' => $orders]) }}
      </div>
    </div>
  </div>
</section>
@endsection
