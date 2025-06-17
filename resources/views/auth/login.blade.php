@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-white dark:bg-gray-900 fade-in">
  <div class="row w-100 shadow-lg rounded-4 overflow-hidden" style="max-width: 960px; background-color: #ffffff;">

    {{-- Left: Login Form --}}
    <div class="col-md-6 p-5 d-flex flex-column justify-content-center bg-white dark:bg-gray-800 text-black dark:text-white">
      <div class="text-center mb-4">
        <img src="{{ asset('racing.png') }}" width="60" alt="logo" class="mb-3">
        <h3 class="fw-bold">Selamat Datang 🖐️</h3>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" required autofocus>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">
          <i class="bi bi-box-arrow-in-right me-1"></i> Log in
        </button>
      </form>
    </div>

    {{-- Right: Illustration --}}
    <div class="col-md-6 bg-light d-none d-md-flex align-items-center justify-content-right position-relative">
      <img src="{{ asset('car.png') }}" alt="Login Illustration" class="img-fluid px-4">
    </div>

  </div>
</div>
@endsection
