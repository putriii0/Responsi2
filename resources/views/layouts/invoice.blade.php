<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Pesanan {{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa; /* Latar belakang abu-abu muda */
        }
        .invoice {
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff; /* Warna putih */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #FF69B4; /* Ganti warna menjadi pink */
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 32px;
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
        .details {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }
        .details p {
            margin: 8px 0;
        }
        .items {
            font-size: 16px;
            color: #555;
        }
        .items h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
        }
        .items table th, .items table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .items table th {
            background-color: #FF69B4; /* Ganti warna menjadi pink */
            color: white;
            font-size: 16px;
        }
        .items table td {
            font-size: 14px;
            color: #555;
        }
        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #FF69B4; /* Ganti warna menjadi pink */
            text-decoration: none;
        }
        .footer p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>Faktur Pesanan</h1>
            <p>{{ $order->id }}</p>
        </div>
        <div class="details">
            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <p><strong>Total:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            @php
                $statusText = [
                    'pending' => 'Pembayaran Sedang Diperiksa',
                    'delivered' => 'Pesanan Telah Diterima Kurir',
                    'arrived' => 'Pesanan Telah Sampai',
                    'completed' => 'Langganan Anda Telah Disetujui',
                    'rejected' => 'Pesanan Telah Ditolak',
                ];
            @endphp
            <p><strong>Status:</strong> {{ $statusText[$order->status] ?? 'Status Tidak Diketahui' }}</p>
        </div>
        <div class="items">
            <h3>Detail Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="total">
            Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}
        </div>
        <div class="footer">
            @if ($order->status === 'accepted')
                <p>Terima kasih telah berbelanja dengan kami!</p>
                <p>Kami berharap Anda puas dengan layanan kami. Jika ada pertanyaan, jangan ragu untuk menghubungi kami di:</p>
                <p><a href="mailto:support@company.com">support@company.com</a></p>
            @elseif ($order->status === 'rejected')
                <p>Mohon maaf, pesanan Anda tidak dapat kami proses.</p>
                <p>Untuk informasi lebih lanjut atau bantuan, silakan hubungi kami di:</p>
                <p><a href="mailto:support@company.com">support@company.com</a></p>
            @else
                <p>Terima kasih telah berbelanja dengan kami!</p>
            @endif
        </div>
    </div>
</body>
</html>
