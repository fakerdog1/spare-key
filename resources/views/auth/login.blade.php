@extends('layouts.guest')

@section('content')
  <!-- Session Status -->
  @if (session('status'))
    <div class="alert alert-success mb-4" role="alert">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
      <label for="login"
        class="form-label"
      >{{ __('Email or Username') }}</label>
      <input id="login"
        class="form-control @error('login') is-invalid @enderror"
        type="text"
        name="login"
        value="{{ old('login') }}"
        required
        autofocus
        autocomplete="username"
      >
      @error('login')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label for="password" class="form-label">{{ __('Password') }}</label>
      <input id="password"
        class="form-control @error('password') is-invalid @enderror"
        type="password"
        name="password"
        required
        autocomplete="current-password"
      >
      @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
      <input id="remember_me"
        type="checkbox"
        class="form-check-input"
        name="remember"
      >
      <label class="form-check-label"
        for="remember_me"
      >{{ __('Remember me') }}</label>
    </div>

    <div class="d-flex justify-content-end align-items-center">
      @if (Route::has('password.request'))
        <a class="text-decoration-none me-3"
          href="{{ route('password.request') }}"
        >
          {{ __('Forgot your password?') }}
        </a>
      @endif

      <button type="submit" class="btn btn-primary text-uppercase">
        {{ __('Log in') }}
      </button>
    </div>
  </form>
@endsection