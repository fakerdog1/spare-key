<x-app-layout>
  <div class="container py-5">
    <div class="row">
      @foreach($rooms as $room)
        @php /** @var \App\Models\Room\Room $room */ @endphp
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <!-- Room Image -->
            <img src="{{ $room->property_url ?? 'https://via.placeholder.com/400x300' }}" class="card-img-top" alt="{{ $room->title }}">

            <div class="card-body">
              <!-- Room Title -->
              <h5 class="card-title">{{ $room->title }}</h5>

              <!-- Room Details -->
              <p class="card-text">
                <strong>Price:</strong> ${{ number_format($room->price, 2) }} / night<br>
                <strong>Available From:</strong> {{ $room->date_from->format('M d, Y') }}<br>
                <strong>Available To:</strong> {{ $room->date_to->format('M d, Y') }}<br>
                <strong>Max Persons:</strong> {{ $room->max_persons }}<br>
                <strong>Spare Keys Left:</strong> {{ $room->spare_keys_left }}
              </p>

              <!-- Room Description (if any) -->
              @if($room->description)
                <p class="card-text">{{ Str::limit($room->description, 100) }}</p>
              @endif
            </div>

            <div class="card-footer bg-white border-top-0">
              <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary w-100">View Details</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</x-app-layout>