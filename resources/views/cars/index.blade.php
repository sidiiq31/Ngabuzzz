@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
  <h2 class="text-white"><i class="bi bi-list-ul"></i> Daftar Mobil</h2>
  <a href="{{ route('cars.create') }}" class="btn btn-warning text-dark fw-semibold shadow-sm">
    <i class="bi bi-plus-lg"></i> Tambah Mobil
  </a>
</div>

@if($cars->count())
  <div class="glass-card p-0 fade-in">
    <div class="table-responsive">
      <table class="table table-borderless text-white align-middle mb-0">
        <thead class="text-uppercase small text-warning border-bottom border-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cars as $car)
            <tr>
              <td>{{ $loop->iteration + ($cars->currentPage()-1)*$cars->perPage() }}</td>
              <td>{{ $car->name }}</td>
              <td><span class="badge badge-info">{{ $car->category->name }}</span></td>
              <td>
                @if($car->stock > 5)
                  <span class="badge badge-success">{{ $car->stock }}</span>
                @elseif($car->stock > 0)
                  <span class="badge badge-warning">{{ $car->stock }}</span>
                @else
                  <span class="badge badge-danger">Habis</span>
                @endif
              </td>
              <td>Rp {{ number_format($car->price, 2, ',', '.') }}</td>
              <td class="text-center">
                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-info me-1">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4 fade-in">
    {{ $cars->links('pagination::bootstrap-5') }}
  </div>
@else
  <div class="alert alert-info text-center text-white bg-opacity-25 bg-white border-0 glass-card fade-in">
    <i class="bi bi-info-circle"></i> Belum ada data mobil. 
    <a href="{{ route('cars.create') }}" class="alert-link text-warning">Tambah sekarang</a>
  </div>
@endif
@endsection
