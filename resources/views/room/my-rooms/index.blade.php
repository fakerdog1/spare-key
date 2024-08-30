@extends('layouts.app')

@php
  $roomTypes = [
    'ownedRooms' => 'Owned Rooms',
    'adminRooms' => 'Admin Rooms',
    'guestRooms' => 'Guest Rooms',
    'waitingRooms' => 'Waiting Rooms',
  ];
@endphp

@section('content')
  <div class="container py-4">
    <h1 class="mb-3">My Rooms</h1>

    @include('room.my-rooms.components.tabs')

    <div class="tab-content" id="roomTabsContent">
      @foreach ($roomTypes as $key => $roomType)
        @include('room.my-rooms.components.tab-pane', ['key' => $key])
      @endforeach
    </div>
  </div>
@endsection