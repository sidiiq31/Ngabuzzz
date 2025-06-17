@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 mb-0 text-white">
    <i class="bi bi-pencil-square me-1"></i> Edit User
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
  <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="username" class="form-label text-white">Username</label>
      <input name="username" id="username" class="form-control @error('username') is-invalid @enderror"
             value="{{ old('username', $user->username) }}" required>
      @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="name" class="form-label text-white">Nama</label>
      <input name="name" id="name" class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $user->name) }}" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label text-white">Role</label>
      <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
        <option value="">-- Pilih Role --</option>
        <option value="superadmin" {{ old('role', $user->role ?? '') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        @foreach($roles as $role)
          @if($role !== 'superadmin')
            <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
              {{ ucfirst($role) }}
            </option>
          @endif
        @endforeach
      </select>
      @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>


    <div class="mb-3">
    <label for="status" class="form-label text-white">Status</label>
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
        <option value="enable" {{ old('status', $user->status ?? 'enable') == 'enable' ? 'selected' : '' }}>Enable</option>
        <option value="disable" {{ old('status', $user->status ?? 'enable') == 'disable' ? 'selected' : '' }}>Disable</option>
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label text-white">Password Baru (kosongkan jika tidak diubah)</label>
      <input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror">
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary fw-semibold">
      <i class="bi bi-save"></i> Update
    </button>
  </form>
</div>
@endsection
