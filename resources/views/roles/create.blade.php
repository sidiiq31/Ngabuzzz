@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 mb-0 text-white">
    <i class="bi bi-person-gear me-1"></i> Tambah Role
  </h1>
  <a href="{{ route('roles.index') }}" class="btn btn-outline-light fw-semibold">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<div class="glass-card fade-in">
  <form action="{{ route('roles.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label text-white">Nama Role</label>
      <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success fw-semibold">
      <i class="bi bi-check-circle"></i> Simpan
    </button>
  </form>
</div>
@endsection
