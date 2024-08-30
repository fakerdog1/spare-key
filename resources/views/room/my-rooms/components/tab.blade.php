<button class="nav-link @if($loop->first) active @endif"
  id="{{ $key }}-tab"
  data-bs-toggle="tab"
  data-bs-target="#{{ $key }}Rooms"
  type="button"
  role="tab"
  aria-controls="{{ $key }}Rooms"
  aria-selected="{{ $loop->first ? 'true' : 'false' }}"
>
  {{ $title }}
</button>
