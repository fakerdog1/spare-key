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
    protected ?Invitation $invitation;

    public function __construct(?Invitation $invitation = null)
    {
        $this->invitation = $invitation;
    }

    /**
     * @return Invitation|null
     */
    public function getInvitation(): ?Invitation
    {
        return $this->invitation;
    }

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

        $this->setInvitation($invitation);

        // Send email with the invitation link
        // Create notification to invitee if profile exists
    }

    /**
     * @throws Exception
     */
    public function cancelInvite(): void
    {
        $this->invitation?->cancel();
        $this->invitation?->delete();
    }

    /**
     * @throws Exception
     */
    public function acceptInvite(): void
    {
        $this->invitation?->accept();
    }

    public function findByToken(string $token): Invitation
    {
        return Invitation::where('token', $token)->firstOrFail();
    }

    public function findByEmail(string $email): Invitation
    {
        return Invitation::where('email', $email)->firstOrFail();
    }

    public function cleanupExpiredInvitations(): void
    {
        Invitation::expired()->notAccepted()->delete();
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



    // Protected methods
    protected function setInvitation(Invitation $invitation): void
    {
        $this->invitation = $invitation;
    }
}