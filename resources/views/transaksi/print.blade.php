<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice #{{ $transaksi->invoice_number }}</title>
  <style>
    body { font-family: sans-serif; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 8px; border: 1px solid #ccc; }
    th { background: #f5f5f5; }
  </style>
</head>
<body onload="window.print()">
  <h2>INVOICE #{{ $transaksi->invoice_number }}</h2>
  <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }}</p>
  <p><strong>Nama:</strong> {{ $transaksi->customer_name }}</p>
  <p><strong>Alamat:</strong> {{ $transaksi->address }}</p>
  <p><strong>Telepon:</strong> {{ $transaksi->phone }}</p>
  <p><strong>Metode Pembayaran:</strong> {{ $transaksi->ket }}</p>

  <table>
    <thead>
      <tr>
        <th>Mobil</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @php $total = 0; @endphp
      @foreach($sales as $sale)
        @php $sub = $sale->quantity * $sale->price_item; $total += $sub; @endphp
        <tr>
          <td>{{ $sale->car->name ?? '-' }}</td>
          <td>Rp {{ number_format($sale->price_item, 0, ',', '.') }}</td>
          <td>{{ $sale->quantity }}</td>
          <td>Rp {{ number_format($sub, 0, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="3" align="right"><strong>Total</strong></td>
        <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
