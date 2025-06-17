@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <h1 class="h4 mb-0 text-white">
      <i class="bi bi-people me-1"></i> Manajemen User
    </h1>
    <a href="{{ route('users.create') }}" class="btn btn-warning text-dark fw-semibold">
      <i class="bi bi-plus-circle"></i> Tambah User
    </a>
  </div>

  <div class="glass-card table-responsive fade-in">
    <table class="table table-hover table-borderless text-white align-middle mb-0">
      <thead class="text-uppercase small text-warning border-bottom border-light">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Role</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr class="{{ $user->status === 'disable' ? 'table-secondary text-muted' : '' }}">
            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td class="text-capitalize">{{ $user->role }}</td>
            <td>{{ $user->email }}</td>
            <td>
              <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center mt-4 fade-in">
    {{ $users->links('pagination::bootstrap-5') }}
  </div>
@endsection
