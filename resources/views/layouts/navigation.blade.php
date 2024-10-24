@php
  $dashboardRoute = route('dashboard');
  $profileEditRoute = route('profile.edit');
  $logoutRoute = route('logout');
  $userName = \Illuminate\Support\Facades\Auth::user()?->username;
  $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand me-4" href="{{ $dashboardRoute }}">
      <img src="#" alt="Logo" height="36">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <x-nav-link :href="$dashboardRoute" :active="$currentRouteName === 'dashboard'">
            <i class="bi bi-house-door-fill me-1"></i>
            Dashboard
          </x-nav-link>
        </li>
      </ul>
      <div class="d-flex">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill me-1"></i>
            {{ $userName }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li>
              <a class="dropdown-item" href="{{ $profileEditRoute }}">
                <i class="bi bi-person me-1"></i>
                Profile
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ $logoutRoute }}">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="bi bi-power me-1"></i>
                  Log Out
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>