@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 mb-0 text-white">
    <i class="bi bi-person-plus-fill me-1"></i> Tambah User
  </h1>
  <a href="{{ route('users.index') }}" class="btn btn-outline-light fw-semibold">
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

<div class="glass-card fade-in">
  <form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="mb-3">
      <label for="username" class="form-label text-white">Username</label>
      <input name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
      @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="name" class="form-label text-white">Nama</label>
      <input name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label text-white">Email</label>
      <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label text-white">Role</label>
      <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
        <option value="">-- Pilih Role --</option>
        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        @foreach($roles as $role)
          <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
        @endforeach
      </select>
      @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>


    <div class="mb-3">
      <label for="password" class="form-label text-white">Password</label>
      <input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-warning fw-semibold text-dark">
      <i class="bi bi-check-circle"></i> Simpan
    </button>
  </form>
</div>
@endsection
