@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 text-white mb-0">
    <i class="bi bi-cart3 me-1"></i> Keranjang Belanja
  </h1>
</div>

@if(session('success'))
  <div class="alert alert-success fade-in">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="alert alert-danger fade-in">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if(count($cart))
  <form action="{{ route('checkout.form') }}" method="GET" class="fade-in">
    @csrf
    <div class="glass-card table-responsive">
      <table class="table table-hover table-borderless align-middle text-white mb-0">
        <thead class="text-uppercase small text-warning border-bottom border-light">
          <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>Gambar</th>
            <th>Nama Mobil</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($cart as $item)
            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
            <tr>
              <td><input type="checkbox" name="items[]" value="{{ $item['car_id'] }}" class="item-checkbox"></td>
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
            <td colspan="5" class="text-end text-warning fw-bold">Total:</td>
            <td colspan="2" class="text-black fw-bold">Rp {{ number_format($total, 2, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <button type="submit" class="btn btn-success mt-3 fw-semibold fade-in">
      <i class="bi bi-bag-check"></i> Checkout yang Dipilih
    </button>

  </form>
  <form action="{{ route('cart.delete.selected') }}" method="POST" class="d-inline-block">
  @csrf
  <input type="hidden" name="items[]" id="deleteItemsInput">
  <button type="submit" class="btn btn-danger mt-3 fw-semibold ms-2 fade-in" onclick="copySelectedItems()">
    <i class="bi bi-trash"></i> Hapus yang Dipilih
  </button>
</form>

<script>
  function copySelectedItems() {
    const selected = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
    const input = document.getElementById('deleteItemsInput');
    input.value = selected.join(',');
  }
</script>
@else
  <div class="alert alert-info fade-in">
    <i class="bi bi-info-circle"></i> Keranjang kosong.
  </div>
@endif

@push('scripts')
<script>
  document.getElementById('selectAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
@endpush
@endsection
