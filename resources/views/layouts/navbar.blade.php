<nav class="navbar navbar-light bg-light shadow-sm py-2">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-controls="offcanvasNav">
      </i>Ngabuzzz
    </button>
    
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column gap-1 p-3 rounded-3" role="tablist"
        style=" --bs-nav-link-color: var(--bs-green);
                --bs-nav-pills-link-active-color: var(--bs-white);
                --bs-nav-pills-link-active-bg: var(--bs-primary);
                --bs-nav-link-padding-x: 0.75rem;
                --bs-nav-link-padding-y: 0.5rem;
                font-size: .875rem;">

        <li class="nav-item" role="presentation">
            <a href="{{ route('dashboard') }}" class="nav-link rounded-pill {{ request()->routeIs('dashboard')?'active':'' }}">
                <i class="bi bi-tags-fill me-1"></i> Home
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('cars.index') }}" class="nav-link rounded-pill {{ request()->routeIs('cars.*')?'active':'' }}">
                <i class="bi bi-list-ul me-1"></i>Mobil
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('categories.index') }}" class="nav-link rounded-pill {{ request()->routeIs('categories.*')?'active':'' }}">
                <i class="bi bi-tags-fill me-1"></i>Kategori
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('sales.index') }}" class="nav-link rounded-pill {{ request()->routeIs('sales.*')?'active':'' }}">
                <i class="bi bi-currency-dollar me-1"></i>Penjualan
            </a>
        </li>
        </ul>
    </div>
    
    </div>
  </div>
</nav>
