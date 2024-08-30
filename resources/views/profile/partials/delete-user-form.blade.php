<section class="mb-4">
  <header>
    <h2 class="h4 text-body">
      {{ __('Delete Account') }}
    </h2>

    <p class="mt-1 text-muted small">
      {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
  </header>

  <button type="button"
    class="btn btn-danger mt-3"
    data-bs-toggle="modal"
    data-bs-target="#confirm-user-deletion"
  >
    {{ __('Delete Account') }}
  </button>

  <div class="modal fade"
    id="confirm-user-deletion"
    tabindex="-1"
    aria-labelledby="confirm-user-deletion-label"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"
            id="confirm-user-deletion-label"
          >{{ __('Delete Account') }}</h5>
          <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form method="post"
            action="{{ route('profile.destroy') }}"
            id="delete-user-form"
          >
            @csrf
            @method('delete')

            <h2 class="h5 text-body">
              {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-muted small">
              {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-3 mt-3">
              <label for="password"
                class="form-label visually-hidden"
              >{{ __('Password') }}</label>
              <input id="password"
                name="password"
                type="password"
                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                placeholder="{{ __('Password') }}"
              >
              @error('password', 'userDeletion')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >{{ __('Cancel') }}</button>
          <button type="submit"
            form="delete-user-form"
            class="btn btn-danger"
          >{{ __('Delete Account') }}</button>
        </div>
      </div>
    </div>
  </div>
</section>