@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 mb-0 text-white">
    <i class="bi bi-ui-checks-grid me-1"></i> Edit Menu untuk Role: <span class="text-warning text-capitalize">{{ $role }}</span>
  </h1>
  <a href="{{ route('roles.index') }}" class="btn btn-outline-light fw-semibold">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<div class="glass-card fade-in">
  <form method="POST" action="{{ route('roles.update', $role) }}">
    @csrf
    @method('PUT')

    <div class="row">
      @foreach($menus as $menu)
        <div class="col-md-6 mb-2">
          <div class="form-check bg-dark bg-opacity-10 p-2 rounded">
            <input 
              type="checkbox" 
              class="form-check-input" 
              name="menu_ids[]" 
              id="menu_{{ $menu->id }}"
              value="{{ $menu->id }}"
              {{ in_array($menu->id, $selected) ? 'checked' : '' }}>
            <label class="form-check-label text-white" for="menu_{{ $menu->id }}">
              {{ $menu->name }}
            </label>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-3">
      <button class="btn btn-success fw-semibold">
        <i class="bi bi-check-circle"></i> Simpan
      </button>
    </div>
  </form>
</div>
@endsection
