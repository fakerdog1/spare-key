<?php

namespace App\Models\Room;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Room
 * @package App\Models\Room
 * @mixin Builder
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $property_url
 * @property int|null $max_persons
 * @property float|null $price
 * @property float|null $total_price
 * @property bool|null $is_booked
 * @property bool|null $is_private
 * @property bool|null $is_democracy
 * @property int $creation_step
 * @property Carbon|null $date_from
 * @property Carbon|null $date_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read int $spare_keys_left
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'property_url',
        'max_persons',
        'price',
        'total_price',
        'is_booked',
        'is_private',
        'is_democracy',
        'date_from',
        'date_to',
        'creation_step',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'max_persons' => 'integer',
        'price' => 'float',
        'total_price' => 'float',
        'is_booked' => 'boolean',
        'is_private' => 'boolean',
        'is_democracy' => 'boolean',
        'date_from' => 'datetime',
        'date_to' => 'datetime',
        'creation_step' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'spare_keys_left',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function owner(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->wherePivot('role', 'owner');
    }

    /** @noinspection PhpUnused */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->wherePivot('role', 'admin');
    }

    /** @noinspection PhpUnused */
    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->wherePivot('role', 'guest');
    }

    /** @noinspection PhpUnused */
    public function waitingRoom(): HasOne
    {
        return $this->hasOne(WaitingRoom::class);
    }

    /** @noinspection PhpUnused */
    public function waitingUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'waiting_room_users'
        )
            ->withPivot(
                'status',
                'request_message',
                'response_message',
                'requested_at',
                'responded_at'
            )
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function getSpareKeysLeftAttribute(): int
    {
        return $this->max_persons - $this->users()->count();
    }
}