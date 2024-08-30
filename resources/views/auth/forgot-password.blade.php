@extends('layouts.guest')

@section('content')
  <div class="mb-4 small text-muted">
    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
  </div>

  <!-- Session Status -->
  @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
      <label for="email" class="form-label">
        {{ __('Email') }}
      </label>
      <input id="email"
        class="form-control @error('email') is-invalid @enderror"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autofocus
      >
      @error('email')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary text-uppercase">
        {{ __('Email Password Reset Link') }}
      </button>
    </div>
  </form>
@endsection