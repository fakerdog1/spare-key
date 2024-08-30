<div class="tab-pane fade @if($loop->first) show active @endif"
  id="{{ $key }}Rooms"
  role="tabpanel"
  aria-labelledby="{{ $key }}-tab"
>
  @if (count($rooms[$key]) > 0)
    @foreach ($rooms[$key] as $room)
      @include('room.my-rooms.components.card.room-card', ['room' => $room])
    @endforeach
  @else
    <p class="text-muted mt-3">No {{ strtolower($key) }} rooms
      found.</p>
  @endif
</div>
