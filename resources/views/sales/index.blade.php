@extends('layouts.app')

@section('content')
<h1 class="h4 mb-4 text-white fw-semibold fade-in">
  <i class="bi bi-cart3 me-1"></i> Penjualan Mobil
</h1>

@if(session('success'))
  <div class="alert alert-success fade-in">
    {{ session('success') }}
  </div>
@endif

<div class="row g-4 fade-in">
  @foreach($cars as $car)
    <div class="col-12 col-md-6 col-lg-4">
      <div class="glass-card h-100 d-flex flex-column shadow border-0">
        {{-- Gambar mobil --}}
        @if($car->image)
          <img src="{{ asset('storage/'.$car->image) }}" class="card-img-top rounded-top" alt="{{ $car->name }}" style="object-fit:cover; height:180px;">
        @else
          <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-top" style="height:180px;">
            <i class="bi bi-image fs-3 me-2"></i> No Image
          </div>
        @endif

        <div class="card-body d-flex flex-column text-white">
          <h5 class="card-title">{{ $car->name }}</h5>
          <p class="card-text mb-2">
            💰 <strong>Rp {{ number_format($car->price,2,',','.') }}</strong>
          </p>
          <p class="text-light mb-4">Stok: {{ $car->stock }}</p>

          {{-- Form tambah penjualan --}}
          <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
            @csrf
            <input type="hidden" name="car_id" value="{{ $car->id }}">
            <div class="input-group mb-2">
              <input 
                type="number"
                name="quantity"
                class="form-control form-control-sm bg-light border-0"
                min="1"
                max="{{ $car->stock }}"
                value="1"
                required
              >
              <button class="btn btn-warning btn-sm text-dark" type="submit">
                <i class="bi bi-cart-plus"></i> Tambah
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  @if($cars->isEmpty())
    <div class="col-12">
      <div class="alert alert-info text-center text-white glass-card">
        <i class="bi bi-info-circle"></i> Tidak ada mobil tersedia untuk dijual.
      </div>
    </div>
  @endif
</div>
@endsection
