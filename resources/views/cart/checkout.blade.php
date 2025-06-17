@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 text-white mb-0">
    <i class="bi bi-bag-check me-1"></i> Konfirmasi Pesanan
  </h1>
</div>

@if(session('error'))
  <div class="alert alert-danger fade-in">{{ session('error') }}</div>
@endif

@if(count($items))
  <div class="glass-card table-responsive mb-4 fade-in">
    <table class="table table-hover table-borderless align-middle text-white mb-0">
      <thead class="text-uppercase small text-warning border-bottom border-light">
        <tr>
          <th>Gambar</th>
          <th>Nama Mobil</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach($items as $item)
          @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
          <tr>
            <td width="100">
              @if($item['image'])
                <img src="{{ asset('storage/'.$item['image']) }}" class="img-fluid rounded shadow-sm" alt="Mobil">
              @else
                <span class="text-muted">No Image</span>
              @endif
            </td>
            <td>{{ $item['name'] }}</td>
            <td>Rp {{ number_format($item['price'], 2, ',', '.') }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>Rp {{ number_format($subtotal, 2, ',', '.') }}</td>
          </tr>
        @endforeach
        <tr class="border-top border-light">
          <td colspan="4" class="text-end text-warning fw-bold">Total:</td>
          <td class="text-black fw-bold">Rp {{ number_format($total, 2, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="glass-card p-4 fade-in">
    <form action="{{ route('checkout.submit') }}" method="POST">
      @csrf
      @foreach($items as $id => $item)
        <input type="hidden" name="items[]" value="{{ $id }}">
      @endforeach

      <div class="mb-3">
        <label for="name" class="form-label text-white">Nama Konsumen</label>
        <input type="text" name="name" id="name" required class="form-control">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label text-white">Nomor Telepon</label>
        <input type="text" name="phone" id="phone" required class="form-control">
      </div>
      <div class="mb-3">
        <label for="address" class="form-label text-white">Alamat Pengiriman</label>
        <textarea name="address" id="address" required class="form-control" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="ket" class="form-label text-white">Metode Pembayaran</label>
        <select name="ket" id="ket" class="form-select" required>
          <option value="">-- Pilih Metode --</option>
          <option value="Bank">Bank Transfer</option>
          <option value="Cash">Cash</option>
          <option value="Debit">Debit</option>
        </select>
      </div>

      <button class="btn btn-success fw-semibold">
        <i class="bi bi-check2-circle"></i> Konfirmasi & Proses
      </button>
    </form>
  </div>
@else
  <div class="alert alert-warning fade-in">
    <i class="bi bi-exclamation-triangle"></i> Tidak ada item yang dipilih untuk checkout.
  </div>
@endif
@endsection
