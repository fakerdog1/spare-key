@php
  $fields = [
      'date_from' => [
          'label' => __('From Date'),
          'placeholder' => __('Select start date'),
      ],
      'date_to' => [
          'label' => __('To Date'),
          'placeholder' => __('Select end date'),
      ],
  ];
@endphp

@foreach ($fields as $field => $config)
  <div class="form-group">
    <label for="{{ $field }}">{{ $config['label'] }}</label>
    <input
      id="{{ $field }}"
      type="date"
      class="form-control @error($field) is-invalid @enderror"
      name="{{ $field }}"
      value="{{ old($field) }}"
      placeholder="{{ $config['placeholder'] }}"
      required
    >
    @error($field)
    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
    @enderror
  </div>
@endforeach