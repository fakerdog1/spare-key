@php
  $field = 'property_url';
  $label = __('Room URL');
  $placeholder = __('Enter the URL of the room');
@endphp

<div class="form-group">
  <label for="{{$field}}">{{$label}}</label>
  <div class="input-group input-group-lg">
    <input
      id="{{$field}}"
      type="text"
      class="form-control @error($field) is-invalid @enderror"
      name="{{$field}}"
      value="{{ old($field) }}"
      placeholder="{{$placeholder}}"
      required
      autofocus
    >
  </div>
  @error($field)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>