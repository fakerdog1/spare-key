<x-app-layout>
  @push('styles')
    <style>
        .footer {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
  @endpush
  @php
    $title = __('Invite User to room');
  @endphp

  <div class="container py-5">
    <form method="POST" action="{{ route('invite.person') }}" id="invitePersonFrom">
      @csrf
      <input type="text" name="room_id" value="">
      <input type="text" name="email" value="">
      <input type="text" name="invitee_id" value="">
      <button type="submit"> invite </button>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </form>
  </div>
</x-app-layout>