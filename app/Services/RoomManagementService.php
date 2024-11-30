<?php

namespace App\Services;

use App\Models\Room\Room;
use App\Models\User;
use Illuminate\Support\Str;

class RoomManagementService
{
    protected Room $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function inviteGuest(string $email): void
    {
        $invitee = User::where('email', $email)->first();
        $invitationService = new InvitationService();
        $invitationService->invite($invitee, $this->room, $email);
    }

    public function generateInviteLink(): void
    {
        $invitationService = new InvitationService();
        $invitationService->invite(null, $this->room);
    }

    public function acceptWaitingUser(User $user): void
    {
        $waitingUser = $this->room->waitingUsers()
            ->where('user_id', $user->id)
            ->first();

        if (!$waitingUser) {
            return;
        }

        if (!$this->room->date_from->isPast()) {
            $waitingUser->update(['status' => 'accepted']);
            $this->room->users()->attach($user, ['role' => 'guest']);
        }
    }

    public function declineWaitingUser(User $user): void
    {
        $waitingUser = $this->room->waitingUsers()
            ->where('user_id', $user->id)
            ->first();

        if (!$waitingUser) {
            return;
        }

        $waitingUser->update(['status' => 'declined']);
    }
}