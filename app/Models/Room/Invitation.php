<?php

namespace App\Models\Room;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class Invitation
 * @package App\Models\Room
 *
 * @mixin Builder
 * @property int $id
 * @property int $room_id
 * @property string $email
 * @property string $token
 * @property string $expires_at
 * @property string $accepted_at
 * @property string $created_at
 * @property string $updated_at
 * @property bool $is_expired
 * @property bool $is_accepted
 * @property bool $is_pending
 * @property string $status
 * @property string $invitation_link
 * @property Room $room
 * @property User $inviter
 *
 * @method static Invitation create(array $array)
 * @method static Builder pending()
 * @method static Builder expired()
 * @method static Builder accepted()
 *
 */
class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'email',
        'token',
        'expires_at',
        'accepted_at',
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
        } elseif ($this->is_expired) {
            return 'expired';
        } else {
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
        return $query->whereNull('accepted_at')->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
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
        if ($this->is_expired) {
            throw new Exception('This invitation has expired.');
        }

        if ($this->is_accepted) {
            throw new Exception('This invitation has already been accepted.');
        }

        $this->update(['accepted_at' => now()]);
    }
}