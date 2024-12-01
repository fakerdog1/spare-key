<x-app-layout>
  <div>
    <div class="actions">
      @if(auth()->user()->id === $room->owner->first()->id)
        @include('room.show.invite-modal')
      @endif
    </div>
    <div class="image-gallery"></div>
    <div></div>
  </div>
</x-app-layout>