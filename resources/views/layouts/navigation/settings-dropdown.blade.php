<div class="dropdown">
  <a href="#"
    class="dropdown-toggle text-decoration-none shadow-none"
    role="button"
    id="dropdownMenuLink"
    data-bs-toggle="dropdown"
    aria-expanded="false"
  >
    {{ Auth::user()->name }}
  </a>
  <ul class="dropdown-menu dropdown-menu-end"
    aria-labelledby="dropdownMenuLink"
  >
    <li>
      <a class="dropdown-item" href="{{ route('profile.edit') }}">
        {{ __('Profile') }}
      </a>
    </li>
    <li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dropdown-item">
          {{ __('Log Out') }}
        </button>
      </form>
    </li>
  </ul>
</div>
