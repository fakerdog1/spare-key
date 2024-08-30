@push('script')
  @vite('resources/js/layouts/navigation.js')
@endpush

<nav id="mainNav"
  class="navbar navbar-expand-sm navbar-light bg-white border-bottom"
>
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="{{ route('dashboard') }}">
      @include('components.application-logo', ['class' => 'd-block text-dark'])
    </a>

    <!-- Hamburger -->
    <button class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarContent"
      aria-controls="navbarContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Navigation Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          @include('components.nav-link', [
              'href' => route('dashboard'),
              'active' => request()->routeIs('dashboard'),
              'text' => __('Dashboard'),
              'class' => 'nav-link'
          ])
        </li>
      </ul>

      <!-- Settings Dropdown -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item mx-3">
          @include('components.create-room-button')
        </li>
        <li class="nav-item dropdown mx-3 d-flex justify-content-center align-items-center">
          @include('layouts.navigation.settings-dropdown')
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Responsive Navigation Menu -->
<div class="d-sm-none">
  <div class="py-2">
    @include('components.responsive-nav-link', [
        'href' => route('dashboard'),
        'active' => request()->routeIs('dashboard'),
        'text' => __('Dashboard'),
        'class' => 'nav-link'
    ])
  </div>

  <!-- Responsive Settings Options -->
  <div class="pt-4 pb-1 border-top">
    <div class="px-4">
      <div class="fw-medium fs-6 text-dark">{{ Auth::user()->name }}</div>
      <div class="fw-medium fs-7 text-muted">{{ Auth::user()->email }}</div>
    </div>

    <div class="mt-3">
      @include('components.responsive-nav-link', [
          'href' => route('profile.edit'),
          'text' => __('Profile'),
          'class' => 'nav-link'
      ])

      <!-- Authentication -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        @include('components.responsive-nav-link', [
            'href' => route('logout'),
            'text' => __('Log Out'),
            'class' => 'nav-link'
        ])
      </form>
    </div>
  </div>
</div>