<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <p class="mb-1">
          <strong>Date:</strong> {{ $room->date_from->format('M d, Y') }}
          - {{ $room->date_to->format('M d, Y') }}</p>
        <p class="mb-1"><strong>Price:</strong>
          ${{ number_format($room->price, 2) }} / night</p>
        <p class="mb-1"><strong>Total Price:</strong>
          ${{ number_format($room->total_price, 2) }}</p>
      </div>
      <div class="col-md-3">
        <p class="mb-1"><strong>Max
            Persons:</strong> {{ $room->max_persons }}</p>
        <p class="mb-1"><strong>Spare
            Keys:</strong> {{ $room->spare_keys_left }}</p>
        <p class="mb-1">
          <strong>Status:</strong>
          <span class="badge {{ $room->is_booked ? 'bg-danger' : 'bg-success' }}">
                                                {{ $room->is_booked ? 'Booked' : 'Available' }}
                                            </span>
        </p>
        <p class="mb-1">
          <strong>Type:</strong> {{ $room->is_private ? 'Private' : 'Public' }}
        </p>
      </div>
      <div class="col-md-4">
        <p class="mb-1">
          <strong>Property URL:</strong>
          @if ($room->property_url)
            <a href="{{ $room->property_url }}" target="_blank">View
              Property</a>
          @else
            N/A
          @endif
        </p>
        <p class="mb-1">
          <strong>Created:</strong> {{ $room->created_at->format('M d, Y H:i') }}
        </p>
        <p class="mb-1"><strong>Last
            Updated:</strong> {{ $room->updated_at->format('M d, Y H:i') }}
        </p>
      </div>
      @include('room.my-rooms.components.card.action-buttons', ['room' => $room])
    </div>
  </div>
</div>
