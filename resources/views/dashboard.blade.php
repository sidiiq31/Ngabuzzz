@extends('layouts.app')

@section('content')
<div class="glass-container py-5">
  <div class="glass-card text-center mb-4">
    <h4 class="fw-bold text-white dark:text-yellow-400">🚗 Selamat Datang di <span class="text-warning">Ngabuzzz!</span></h4>
    <p class="text-sm text-white/80 dark:text-gray-300 mt-1">Pantau kategori mobil dan progres penjualannya secara real-time.</p>
  </div>

  <div class="row g-4">
    @foreach($categories as $category)
      @php
        $totalCars = $category->cars->sum('stock') + $category->cars->sum('sales_count');
        $totalSold = $category->cars->sum('sales_count');
        $percentage = $totalCars > 0 ? round(($totalSold / $totalCars) * 100) : 0;
        $badgeClass = 'bg-secondary';
        if ($percentage >= 75) $badgeClass = 'bg-success';
        elseif ($percentage >= 40) $badgeClass = 'bg-warning text-dark';
        elseif ($percentage > 0) $badgeClass = 'bg-danger';
      @endphp

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl text-white dark:text-white shadow-lg transition hover:scale-[1.02] hover:shadow-xl h-100">
          
          @php
            $firstCarWithImage = $category->cars->firstWhere('image', '!=', null);
          @endphp

          @if($firstCarWithImage && $firstCarWithImage->image)
            <img src="{{ asset('storage/'.$firstCarWithImage->image) }}" class="card-img-top object-cover" style="height:180px;" alt="{{ $firstCarWithImage->name }}">
          @else
            <div class="d-flex align-items-center justify-content-center" style="height:180px; background-color: rgba(255,255,255,0.1);">
              <i class="bi bi-image text-white opacity-75" style="font-size:2rem;"></i> &nbsp; No Image
            </div>
          @endif

          <div class="card-body">
            <h5 class="card-title text-warning">{{ $category->name }}</h5>

            @if($category->cars->count())
              <ul class="list-group list-group-flush mb-3">
                @foreach($category->cars as $car)
                  <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 text-white">
                    {{ $car->name }}
                    <span class="badge 
                      @if($car->stock > 5) bg-success
                      @elseif($car->stock > 0) bg-warning text-dark
                      @else bg-danger
                      @endif">
                      Stok: {{ $car->stock }}
                    </span>
                  </li>
                @endforeach
              </ul>
            @else
              <p class="text-muted text-white/70">Belum ada mobil di kategori ini.</p>
            @endif

            <div class="d-flex justify-content-between align-items-center mt-2">
              <span class="fw-semibold">Penjualan:</span>
              <span class="badge {{ $badgeClass }}">
                {{ $totalSold }} / {{ $totalCars }} ({{ $percentage }}%)
              </span>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
