@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h1 class="h4 text-white"><i class="bi bi-tags"></i> Kategori</h1>
  <a href="{{ route('categories.create') }}" class="btn btn-warning fw-semibold text-dark">
    <i class="bi bi-plus-lg"></i> Tambah Kategori
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success fade-in">
    {{ session('success') }}
  </div>
@endif

<div class="glass-card table-responsive fade-in">
  <table class="table table-borderless text-white align-middle mb-0">
    <thead class="text-uppercase small text-warning border-bottom border-light">
      <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $cat)
        <tr>
          <td>{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
          <td>{{ $cat->name }}</td>
          <td class="text-center">
            <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-info me-1">
              <i class="bi bi-pencil"></i>
            </a>
            <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="d-flex justify-content-center mt-4 fade-in">
  {{ $categories->links('pagination::bootstrap-5') }}
</div>
@endsection
