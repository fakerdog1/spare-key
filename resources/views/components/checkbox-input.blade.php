@props(['name', 'checked' => false])

<input
  type="checkbox"
  name="{{ $name }}"
  id="{{ $name }}"
  {{ $checked ? 'checked' : '' }}
  {{ $attributes->merge(['class' => 'form-check-input']) }}
>