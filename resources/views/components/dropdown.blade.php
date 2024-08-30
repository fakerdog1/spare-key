@props(['align' => 'end', 'width' => '10rem', 'contentClasses' => 'py-1 bg-white'])

@php
  $alignmentClasses = match ($align) {
      'start' => 'dropdown-menu-start',
      'end' => 'dropdown-menu-end',
      default => '',
  };
@endphp

<div class="dropdown">
  @include($trigger)

  <ul class="dropdown-menu {{ $alignmentClasses }}"
    style="min-width: {{ $width }};"
  >
    @include($content)
  </ul>
</div>