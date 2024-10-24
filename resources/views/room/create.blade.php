<x-app-layout>
  @push('styles')
    <style>
        .footer {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
  @endpush
  @php
    $title = __('Create Room');
    $keys = [
        1 => 'url',
        2 => 'specifications',
        3 => 'dates',
    ];
    $key = data_get($keys, $step);
    $totalSteps = count($keys);
    $progress = ($step / $totalSteps) * 100;
  @endphp

  <div class="container py-5">
    <form method="POST" action="{{ route('room.store') }}" id="createRoomForm">
      @csrf
      <input type="hidden" name="step" value="{{ $step }}">

      @include("room.steps.$key")
    </form>
  </div>

  @section('footer')
    @include('room.partials.footer', [
      'step' => $step,
      'totalSteps' => $totalSteps,
      'progress' => $progress
    ])
  @endsection

</x-app-layout>