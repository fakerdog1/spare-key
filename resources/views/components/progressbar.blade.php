@push('styles')
  @vite('resources/css/components/progressbar.css')
@endpush

<div class="progress-bar bg-primary"
  role="progressbar"
  style="width: {{ $progress }}%;"
  aria-valuenow="{{ $progress }}"
  aria-valuemin="0"
  aria-valuemax="100"
></div>
