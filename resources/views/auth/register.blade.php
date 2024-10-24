<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
      <x-input-label for="username" :value="__('Username')" />
      <x-text-input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mb-3">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mb-3">
      <x-input-label for="first_name" :value="__('First Name')" />
      <x-text-input id="first_name" class="form-control" type="name" name="first_name" :value="old('first_name')" required autocomplete="first_name" />
      <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mb-3">
      <x-input-label for="last_name" :value="__('Last Name')" />
      <x-text-input id="last_name" class="form-control" type="last_name" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
      <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mb-3">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input id="password" class="form-control"
        type="password"
        name="password"
        required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

      <x-text-input id="password_confirmation" class="form-control"
        type="password"
        name="password_confirmation" required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="d-flex justify-content-end align-items-center mt-4">
      <a class="text-decoration-none me-3" href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>

      <x-primary-button class="btn btn-primary">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>