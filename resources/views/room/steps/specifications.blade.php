@php
  /** @var \App\Models\Room\Room $room */
  $fields = [
      'max_persons' => [
          'label' => __('Maximum number of guests'),
          'type' => 'number',
          'placeholder' => __('Enter number'),
          'value' => old('max_persons') ?? $room->max_persons ?? 0,
      ],
      'price' => [
          'label' => __('Price per night'),
          'type' => 'number',
          'placeholder' => __('Enter price'),
          'step' => '0.01',
          'prepend' => '$',
          'value' => old('price') ?? $room->price ?? 0,
      ],
      'is_booked' => [
          'label' => __('Room is currently booked'),
          'type' => 'switch',
          'value' => old('is_booked') ?? $room->is_booked ?? false,
      ],
      'is_private' => [
          'label' => __('Private room'),
          'type' => 'switch',
          'value' => old('is_private') ?? $room->is_private ?? false,
      ],
      'is_democracy' => [
          'label' => __('Democratic decision-making for guests'),
          'type' => 'switch',
          'value' => old('is_democracy') ?? $room->is_democracy ?? false,
      ],
  ];
@endphp

<div class="container py-4">
  <h2 class="mb-4">{{ __('Room Specifications') }}</h2>

  <div class="row g-3">
    @foreach ($fields as $field => $config)
      @if ($config['type'] === 'switch')
        <div class="col-12">
          <div class="form-check form-switch">
            <input
              id="{{ $field }}"
              type="checkbox"
              class="form-check-input @error($field) is-invalid @enderror"
              name="{{ $field }}"
              value={{ $config['value'] }}
              {{ old($field) ? 'checked' : '' }}
            >
            <label class="form-check-label" for="{{ $field }}">{{ $config['label'] }}</label>
          </div>
        </div>
      @else
        <div class="col-md-6">
          <label for="{{ $field }}" class="form-label">{{ $config['label'] }}</label>
          <div class="input-group">
            @if (isset($config['prepend']))
              <span class="input-group-text">{{ $config['prepend'] }}</span>
            @endif
            <input
              id="{{ $field }}"
              type="{{ $config['type'] }}"
              class="form-control @error($field) is-invalid @enderror"
              name="{{ $field }}"
              value={{ $config['value'] }}
              placeholder="{{ $config['placeholder'] }}"
              @if (isset($config['step'])) step="{{ $config['step'] }}" @endif
            required
            >
          </div>
          @error($field)
          <div class="invalid-feedback d-block">
            {{ $message }}
          </div>
          @enderror
        </div>
      @endif
    @endforeach
  </div>
</div>

@push('styles')
  <style>
      .form-check-input {
          width: 2.5em;
          height: 1.25em;
      }
      .form-check-label {
          padding-left: 0.5em;
          padding-top: 0.1em;
      }
      .input-group-text {
          background-color: #f8f9fa;
      }
      .form-control::placeholder {
          color: #6c757d;
          opacity: 0.7;
      }
  </style>
@endpush