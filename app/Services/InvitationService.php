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
    protected ?string $token;

    public function __construct(
        ?Invitation $invitation = null,
        ?string $token = null,
    ) {
        $this->invitation = $invitation ?? $this->findByToken($token);
    }

    /**
     * @return Invitation|null
     */
    public function getInvitation(): ?Invitation
    {
        return $this->invitation;
    }

    // General methods
    public function invite(
        ?User $user,
        Room $room,
        ?string $type = Invitation::TYPE_GROUP,
        ?string $email = null,
    ): void {
        if (!Invitation::typeIsValid($type)) {
            $type = Invitation::TYPE_GROUP;
        }

        $userEmail = $user?->email ?? $email;
        $invitationEmail = $type === Invitation::TYPE_PERSONAL ? $userEmail : null;
        $maxUseCount = $type === Invitation::TYPE_PERSONAL ? 1 : $room->max_persons; // TODO change here to calculate the max available number of users

        $invitation = $room->invitations()->create([
            'inviter_id' => auth()->id(),
            'invitee_id' => $user?->id,
            'type' => $type,
            'email' => $invitationEmail,
            'token' => Str::random(32),
            'max_use_count' => $maxUseCount,
            'expires_at' => now()->addHours(2),
        ]);

        $this->setInvitation($invitation);
        $acceptUrl = route('invitation.accept', ['token' => $invitation->token]);

        // TODO: Send email with the invitation link
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
        $this->invitation->room->users()->attach(
            auth()->id(),
            [
                'role' => 'guest',
                'invitation_id' => $this->invitation->id,
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function declineInvite(): void
    {
        $this->invitation?->decline();
    }

    public function findByToken(?string $token): ?Invitation
    {
        if (!$token) {
            return null;
        }

        return Invitation::where('token', $token)->first();
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