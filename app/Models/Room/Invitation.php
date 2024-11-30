<?php

namespace App\Models\Room;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Invitation
 * @package App\Models\Room
 *
 * @mixin Builder
 * @property int $id
 * @property int $room_id
 * @property int $inviter_id
 * @property int $invitee_id
 * @property string $email
 * @property string $type
 * @property string $token
 * @property int $max_use_count
 * @property int $use_count
 * @property string $expires_at
 * @property string $accepted_at
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property bool $is_expired
 * @property bool $is_accepted
 * @property bool $is_pending
 * @property string $status
 * @property string $invitation_link
 * @property Room $room
 * @property User $inviter
 * @property User $invitee
 *
 * @method self|Builder pending()
 * @method self|Builder expired()
 * @method self|Builder accepted()
 * @method self|Builder notAccepted()
 *
 */
class Invitation extends Model
{
    public const TYPE_PERSONAL = 'personal';
    public const TYPE_GROUP = 'group';

    protected $fillable = [
        'room_id',
        'inviter_id',
        'invitee_id',
        'email',
        'type',
        'token',
        'max_use_count',
        'use_count',
        'expires_at',
        'accepted_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function invitee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }


    // Attributes
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at <= now();
    }

    public function getIsAcceptedAttribute(): bool
    {
        return $this->accepted_at !== null;
    }

    public function getIsPendingAttribute(): bool
    {
        return !$this->is_accepted && !$this->is_expired;
    }

    public function getStatusAttribute(): string
    {
        if ($this->is_accepted) {
            return 'accepted';
        }
        else if ($this->is_expired) {
            return 'expired';
        }
        else {
            return 'pending';
        }
    }

    public function getInvitationLinkAttribute(): string
    {
        return url("/invitations/$this->token");
    }


    // Scopes
    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')->where(
            'expires_at',
            '>',
            now()
        );
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeNotAccepted($query)
    {
        return $query->whereNull('accepted_at');
    }

    public function scopeAccepted($query)
    {
        return $query->whereNotNull('accepted_at');
    }


    // Methods
    public static function createInvitation($roomId, $email, $inviterId = null)
    {
        return self::create([
            'room_id' => $roomId,
            'email' => $email,
            'inviter_id' => $inviterId,
            'token' => Str::random(32),
            'expires_at' => now()->addDays(7),
        ]);
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        $userInvalid = !auth()->user();
        if ($userInvalid) {
            throw new Exception(
                'You are not authorized to accept this invitation.'
            );
        }

        if ($this->type === self::TYPE_PERSONAL && $this->email !== auth()->user()->email) {
            throw new Exception('You are not authorized to accept this invitation.');
        }

        if (!$this->is_active) {
            throw new Exception('This invitation has been canceled.');
        }

        if ($this->is_expired) {
            throw new Exception('This invitation has expired.');
        }

        if ($this->is_accepted) {
            throw new Exception('This invitation has already been accepted.');
        }

        if ($this->room->users->contains(auth()->id())) {
            throw new Exception('You are already a member of this room.');
        }

        $this->update([
            'invitee_id' => $this->invitee_id ?? auth()->id(),
            'accepted_at' => $this->type === self::TYPE_PERSONAL ? now() : null,
            'is_active' => !($this->type === self::TYPE_PERSONAL),
            'use_count' => $this->use_count + 1,
        ]);
    }

    /**
     * @throws Exception
     */
    public function decline(): void
    {
        if ($this->type === self::TYPE_GROUP) {
            return;
        }

        if (!auth()->user() || $this->email !== auth()->user()->email) {
            throw new Exception(
                'You are not authorized to decline this invitation.'
            );
        }

        if ($this->is_accepted) {
            throw new Exception('This invitation has already been accepted.');
        }

        if (!$this->is_active) {
            throw new Exception('This invitation has been canceled.');
        }

        if ($this->is_expired) {
            throw new Exception('This invitation has expired.');
        }

        $this->update(['is_active' => false]);
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        if (!auth()->user()) {
            throw new Exception('Not authorized');
        }

        $isRoomOwner = $this->room->owner->first()->id === auth()->id();
        $isInviter = $this->inviter_id === auth()->id();

        if (!$isRoomOwner && !$isInviter) {
            throw new Exception('Not authorized');
        }
        $this->update(['is_active' => false]);
    }

    public static function typeIsValid(string $type): bool
    {
        return in_array($type, [
            self::TYPE_PERSONAL,
            self::TYPE_GROUP,
        ]);
    }
}