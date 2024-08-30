@props(['href', 'text'])

<li>
  <a href="{{ $href }}" {{ $attributes->merge(['class' => 'dropdown-item']) }}>
    {{ $text }}
  </a>
</li>