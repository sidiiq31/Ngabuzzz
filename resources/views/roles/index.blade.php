@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="glass-card shadow fade-in border-0">
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <h4 class="text-white mb-0">
          <i class="bi bi-sliders me-2"></i> Management Role
        </h4>
        @if(Auth::user()->role === 'superadmin')
          <a href="{{ route('roles.create') }}" class="btn btn-warning btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Role
          </a>
        @endif
      </div>

      <p class="text-light mb-3">Pilih role untuk mengatur menu yang ditampilkan:</p>

      <ul class="list-group list-group-flush">
        @foreach($roles as $role)
          <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center text-white border-white border-opacity-25">
            <span class="text-capitalize">{{ $role }}</span>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-light btn-sm">
              <i class="bi bi-pencil-square"></i> Edit Menu
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endsection
