@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <h1 class="h3">Edit Penjualan</h1>
  <a href="{{ route('sales.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('sales.update', $sale) }}" method="POST">
  @csrf @method('PATCH')
  <div class="mb-3">
    <label for="car_id" class="form-label">Pilih Mobil</label>
    <select name="car_id" id="car_id"
            class="form-select @error('car_id') is-invalid @enderror">
      @foreach($cars as $id => $name)
        <option value="{{ $id }}"
          {{ old('car_id', $sale->car_id)==$id?'selected':'' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('car_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="quantity" class="form-label">Jumlah</label>
    <input
      type="number"
      name="quantity"
      id="quantity"
      min="1"
      class="form-control @error('quantity') is-invalid @enderror"
      value="{{ old('quantity', $sale->quantity) }}"
    >
    @error('quantity')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <button class="btn btn-primary">
    <i class="bi bi-pencil"></i> Update
  </button>
</form>
@endsection
