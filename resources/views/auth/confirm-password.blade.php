@extends('layouts.guest')

@section('content')
  <div class="mb-4 small text-muted">
    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
  </div>

  <form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <!-- Password -->
    <div class="mb-3">
      <label for="password" class="form-label">
        {{ __('Password') }}
      </label>

      <input id="password"
        class="form-control @error('password') is-invalid @enderror"
        type="password"
        name="password"
        required
        autocomplete="current-password"
      >

      @error('password')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="submit" class="btn btn-primary text-uppercase">
        {{ __('Confirm') }}
      </button>
    </div>
  </form>
@endsection