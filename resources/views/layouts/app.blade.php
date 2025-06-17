<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ngabuzzz</title>
  <link rel="icon" href="{{ asset('racing.png') }}" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
  @vite(['resources/css/app.css'])
</head>
<body class="glass-container" id="body">

  <nav class="navbar shadow-sm py-2 sticky-top transition-colors duration-300 
            bg-white text-black 
            dark:bg-gray-800 dark:text-white">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand fw-bold text-primary dark:text-white" 
       role="button" 
       data-bs-toggle="offcanvas" 
       data-bs-target="#sidebar" 
       aria-controls="sidebar">
      <i class="bi bi-car-front-fill me-1"></i>Ngabuzzz
    </a>

    <!-- Tombol Toggle Mode -->
    <button class="btn btn-outline-secondary dark:btn-outline-light btn-sm" id="toggleMode">
      <i class="bi bi-moon-fill"></i> Mode
    </button>
  </div>
</nav>

  @php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user->role ?? 'guest';

    $menus = $role === 'superadmin'
        ? Menu::all()
        : Menu::whereHas('roles', fn($q) => $q->where('role', $role))->get();
  @endphp

  <div class="offcanvas offcanvas-start bg-white text-black dark:bg-gray-900 dark:text-white transition-colors duration-300" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header border-bottom border-light-subtle dark:border-gray-700">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close text-reset dark:invert" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0">
    <ul class="nav nav-pills flex-column gap-2 p-3">
      @foreach($menus as $menu)
        <li class="nav-item">
          <button class="nav-link text-start w-100 {{ request()->routeIs($menu->route . '*') ? 'nav-link-active' : '' }}"
            onclick="window.location.href='{{ route($menu->route) }}'">
            <i class="bi {{ $menu->icon }} me-2"></i>{{ $menu->name }}
          </button>
        </li>
      @endforeach

      @if($user && $user->role === 'superadmin')
        <li class="nav-item">
          <button class="nav-link text-start w-100 {{ request()->routeIs('roles.*') ? 'nav-link-active' : '' }}"
            onclick="window.location.href='{{ route('roles.index') }}'">
            <i class="bi bi-sliders me-2"></i>Management Role
          </button>
        </li>
      @endif

      @if(session('cart'))
        <li class="nav-item mt-4">
          <button class="nav-link text-start w-100 position-relative {{ request()->routeIs('cart.*') ? 'nav-link-active' : '' }}"
            onclick="window.location.href='{{ route('cart.index') }}'">
            <i class="bi bi-cart3 me-2"></i>Keranjang
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              {{ count(session('cart')) }}
            </span>
          </button>
        </li>
      @endif

      @auth
        <li class="nav-item">
          <button class="nav-link text-start w-100 {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
            onclick="window.location.href='{{ route('profile.show') }}'">
            <i class="bi bi-person-circle me-2"></i>Profil Saya
          </button>
        </li>

        <li class="nav-item mt-5 border-top border-light-subtle dark:border-gray-700 pt-3">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link text-start w-100 btn btn-outline-info dark:btn-outline-light" type="submit">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
          </form>
        </li>

        <li class="nav-item mt-4">
          <div class="glass-card text-center mx-3 mt-3 py-3 fade-in">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                width="60"
                class="rounded-circle shadow-sm mb-2 mx-auto d-block"
                alt="avatar">
            <div class="text-black dark:text-white fw-semibold">{{ strtoupper(Auth::user()->username) }}</div>
            <div class="text-black dark:text-white text-capitalize small">{{ Auth::user()->role }}</div>
          </div>
        </li>
      @endauth
    </ul>
  </div>
</div>


  <main class="main-theme">
    <div class="container container-theme">
      @yield('content')
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  @vite(['resources/js/app.js'])

  <script>
    const toggleBtn = document.getElementById('toggleMode');
    const body = document.body;
    
    body.classList.add('transition-colors', 'duration-500', 'ease-in-out');
    
    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark');
    }

    toggleBtn.addEventListener('click', function () {
      body.classList.toggle('dark');

      localStorage.setItem('theme',
        body.classList.contains('dark') ? 'dark' : 'light'
      );
    });
  </script>
</body>
</html>
