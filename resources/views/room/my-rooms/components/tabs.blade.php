<ul class="nav nav-tabs mb-4" id="roomTabs" role="tablist">
  @foreach ($roomTypes as $key => $title)
    <li class="nav-item" role="presentation">
      @include('room.my-rooms.components.tab', ['key' => $key, 'title' => $title])
    </li>
  @endforeach
</ul>