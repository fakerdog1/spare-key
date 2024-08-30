@props(['active', 'href', 'text'])

@php
  $classes = 'nav-link';
  if ($active ?? false) {
      $classes .= ' active';
  }
@endphp

<li class="nav-item">
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $text }}
  </a>
</li>