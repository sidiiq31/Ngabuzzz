@extends('layouts.app')

@section('content')
<div class="mb-4 fade-in d-flex justify-content-between align-items-center">
  <h1 class="h4 text-white"><i class="bi bi-plus-circle"></i> Tambah Kategori</h1>
  <a href="{{ route('categories.index') }}" class="btn btn-outline-light">
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
  <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label text-white">📁 Nama Kategori</label>
      <input type="text" name="name" id="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name') }}" placeholder="Contoh: Baru, Bekas, dll">
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex gap-2 mt-3">
      <button class="btn btn-success">
        <i class="bi bi-check-circle"></i> Simpan
      </button>
      <a href="{{ route('categories.index') }}" class="btn btn-outline-light">
        <i class="bi bi-x-circle"></i> Batal
      </a>
    </div>
  </form>
</div>
@endsection
