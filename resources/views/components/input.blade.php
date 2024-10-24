@props(['type' => 'text', 'name', 'value' => '', 'placeholder' => ''])

<input
  type="{{ $type }}"
  name="{{ $name }}"
  id="{{ $name }}"
  value="{{ $value }}"
  placeholder="{{ $placeholder }}"
  {{ $attributes->merge(['class' => 'form-control']) }}
>