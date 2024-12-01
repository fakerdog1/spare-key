@push('styles')
  @vite('resources/css/components/progressbar.css')
@endpush

<div class="pb-3 w-100">
  <!-- Progress Bar -->
  <div class="progress mb-3 thin-progress">
    @include('components.progressbar', ['progress' => $progress])
  </div>

  <!-- Footer with Navigation Buttons -->
  <div class="d-flex justify-content-between px-5 py-2">
    @if ($step > 1)
      <a type="button" class="btn btn-link text-decoration-underline" href="{{ route('room.create', ['step' => $step - 1]) }}">
        <u>
          &laquo; {{ __('Back') }}
        </u>
      </a>
    @else
      <div></div>
    @endif

    @if ($step < $totalSteps)
      <button type="submit" form="createRoomForm" class="btn btn-lg btn-primary me-5">
        {{ __('Next') }} &raquo;
      </button>
    @else
      <button type="submit" form="createRoomForm" class="btn btn-lg btn-success me-5">
        {{ __('Publish') }}
      </button>
    @endif
  </div>
</div>