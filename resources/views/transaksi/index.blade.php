@extends('layouts.app')

@section('content')
<h1 class="h4 mb-4 text-white fw-semibold fade-in">
  <i class="bi bi-receipt me-1"></i> Riwayat Transaksi
</h1>

<form method="GET" action="{{ route('transaksi.index') }}" class="row g-3 align-items-end mb-4 fade-in">
  <div class="col-md-4">
    <label for="start_date" class="form-label text-white">Dari Tanggal</label>
    <input type="date" name="start_date" id="start_date" class="form-control bg-light border-0"
      value="{{ request('start_date') ?? \Carbon\Carbon::now()->toDateString() }}">
  </div>
  <div class="col-md-4">
    <label for="end_date" class="form-label text-white">Sampai Tanggal</label>
    <input type="date" name="end_date" id="end_date" class="form-control bg-light border-0"
      value="{{ request('end_date') ?? \Carbon\Carbon::now()->toDateString() }}">
  </div>
  <div class="col-md-4">
    <button class="btn btn-warning w-100 text-dark fw-semibold">
      <i class="bi bi-filter"></i> Filter
    </button>
  </div>
</form>

@if($transaksis->count())
  <div class="glass-card table-responsive fade-in">
    <table class="table table-hover table-borderless text-white align-middle mb-0">
      <thead class="text-uppercase small text-warning border-bottom border-light">
        <tr>
          <th>No</th>
          <th>Invoice</th>
          <th>Nama Konsumen</th>
          <th>Total</th>
          <th>Pembayaran</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transaksis as $t)
          <tr>
            <td>{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
            <td>{{ $t->invoice_number }}</td>
            <td>{{ $t->customer_name }}</td>
            <td>Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($t->payment_amount, 0, ',', '.') }}</td>
            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
            <td>
              <a href="{{ route('transaksi.print', $t->invoice_number) }}" target="_blank"
                 class="btn btn-outline-info btn-sm">
                <i class="bi bi-printer"></i> Print
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center mt-3 fade-in">
    {{ $transaksis->appends(request()->query())->links('pagination::bootstrap-5') }}
  </div>
@else
  <div class="alert alert-info glass-card text-white fade-in">
    <i class="bi bi-info-circle"></i> Tidak ada data transaksi untuk tanggal yang dipilih.
  </div>
@endif
@endsection
