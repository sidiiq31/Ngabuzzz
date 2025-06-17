@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center fade-in">
  <h1 class="h4 text-white"><i class="bi bi-pencil"></i> Edit Mobil</h1>
  <a href="{{ route('cars.index') }}" class="btn btn-outline-light">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

@if($errors->any())
  <div class="alert alert-danger glass-card text-white">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="glass-card p-4 fade-in">
  <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PATCH')

    <div class="mb-3">
      <label for="image" class="form-label text-white">📸 Gambar Mobil</label>
      <input type="file" name="image" id="image"
             class="form-control @error('image') is-invalid @enderror"
             accept="image/*">
      @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

      @if($car->image)
        <div class="mt-3">
          <img src="{{ asset('storage/'.$car->image) }}"
               alt="{{ $car->name }}"
               class="img-thumbnail shadow-sm"
               style="max-width:150px;">
        </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="category_id" class="form-label text-white">📂 Kategori <span class="text-danger">*</span></label>
      <select name="category_id" id="category_id"
              class="form-select @error('category_id') is-invalid @enderror" required>
        @foreach($categories as $id => $name)
          <option value="{{ $id }}" {{ old('category_id', $car->category_id)==$id?'selected':'' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
      @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="name" class="form-label text-white">🚗 Nama Mobil</label>
      <input type="text" name="name" id="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $car->name) }}">
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="description" class="form-label text-white">📝 Deskripsi</label>
      <textarea name="description" id="description" rows="3"
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $car->description) }}</textarea>
      @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="stock" class="form-label text-white">📦 Stok</label>
        <input type="number" name="stock" id="stock" min="0"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $car->stock) }}">
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="price" class="form-label text-white">💵 Harga</label>
        <input type="number" name="price" id="price" min="0" step="0.01"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $car->price) }}">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    <button class="btn btn-success fw-semibold">
      <i class="bi bi-save me-1"></i> Simpan Perubahan
    </button>
  </form>
</div>
@endsection
