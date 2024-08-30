@props(['active', 'href', 'text'])

@php
  $classes = ($active ?? false)
              ? 'nav-link active'
              : 'nav-link';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
  {{ $text }}
</a>
