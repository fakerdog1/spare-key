<invite-modal
  :room-id="{{ $room->id }}"
  :invite-group-url="`{{ route('invite.group') }}`"
  :invite-personal-url="`{{ route('invite.multiple') }}`"
  :search-url="`{{ route('api.user.search') }}`">
</invite-modal>