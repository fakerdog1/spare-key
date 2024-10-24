<?php

namespace App\Services;

use App\Models\Room\Invitation;
use App\Models\Room\Room;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Class InvitationService
 * @package App\Services
 */
class InvitationService
{
    // General methods
    public function invite(?User $user, Room $room, string $email): void
    {
        $invitation = $room->invitations()->create([
            'inviter_id' => auth()->id(),
            'invitee_id' => $user?->id,
            'email' => $user?->email ?? $email,
            'token' => Str::random(32),
            'expires_at' => now()->addHours(2),
        ]);

        // Send email with the invitation link
        // Create notification to invitee if profile exists
    }

    public function cancelInvite(Invitation $invitation): void
    {
        $invitation->cancel();
        $invitation->delete();
    }

    /**
     * @throws Exception
     */
    public function acceptInvite(Invitation $invitation): void
    {
        $invitation->accept();
    }

    public function findByToken(string $token): Invitation
    {
        return Invitation::where('token', $token)->firstOrFail();
    }

    public function findByEmail(string $email): Invitation
    {
        return Invitation::where('email', $email)->firstOrFail();
    }



    // User specific methods
    /**
     * @param User $user
     * @return Invitation[]|Collection
     */
    public function getPendingReceivedForUser(User $user): Invitation|Collection
    {
        return $user->invitations()->pending()->get();
    }

    /**
     * @param User $user
     * @return Invitation[]|Collection
     */
    public function getPendingSentForUser(User $user): Invitation|Collection
    {
        return $user->sentInvitations()->pending()->get();
    }



    // Room specific methods
    /**
     * @param Room $room
     * @return Invitation[]|Collection
     */
    public function getPendingReceivedForRoom(Room $room): Invitation|Collection
    {
        return $room->invitations()->pending()->get();
    }

    /**
     * @param Room $room
     * @return Invitation[]|Collection
     */
    public function getPendingSentForRoom(Room $room): Invitation|Collection
    {
        return $room->invitations()->pending()->get();
    }
}