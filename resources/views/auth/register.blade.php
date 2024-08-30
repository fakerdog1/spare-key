@extends('layouts.guest')

@section('content')
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Username -->
    <div class="mb-3">
      <label for="username" class="form-label">{{ __('Username') }}</label>
      <input id="username"
        class="form-control @error('username') is-invalid @enderror"
        type="text"
        name="username"
        value="{{ old('username') }}"
        required
        autofocus
        autocomplete="username"
      >
      @error('username')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- First Name -->
    <div class="mb-3">
      <label for="first_name" class="form-label">{{ __('First Name') }}</label>
      <input id="first_name"
        class="form-control @error('first_name') is-invalid @enderror"
        type="text"
        name="first_name"
        value="{{ old('first_name') }}"
        required
        autocomplete="given-name"
      >
      @error('first_name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Last Name -->
    <div class="mb-3">
      <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
      <input id="last_name"
        class="form-control @error('last_name') is-invalid @enderror"
        type="text"
        name="last_name"
        value="{{ old('last_name') }}"
        required
        autocomplete="family-name"
      >
      @error('last_name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input id="email"
        class="form-control @error('email') is-invalid @enderror"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autocomplete="email"
      >
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Phone Number -->
    <div class="mb-3">
      <label for="phone_number"
        class="form-label"
      >{{ __('Phone Number') }}</label>
      <input id="phone_number"
        class="form-control @error('phone_number') is-invalid @enderror"
        type="tel"
        name="phone_number"
        value="{{ old('phone_number') }}"
        autocomplete="tel"
      >
      @error('phone_number')
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
        autocomplete="new-password"
      >
      @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
      <label for="password_confirmation"
        class="form-label"
      >{{ __('Confirm Password') }}</label>
      <input id="password_confirmation"
        class="form-control @error('password_confirmation') is-invalid @enderror"
        type="password"
        name="password_confirmation"
        required
        autocomplete="new-password"
      >
      @error('password_confirmation')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-end align-items-center">
      <a class="text-decoration-none me-3" href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>

      <button type="submit" class="btn btn-primary text-uppercase">
        {{ __('Register') }}
      </button>
    </div>
  </form>
@endsection