@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Edit Profil</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}" readonly>
      </div>

      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" value="{{ old('name', $user->name) }}">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password Baru (opsional)</label>
        <input type="password" class="form-control" name="password">
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" name="password_confirmation">
      </div>

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
