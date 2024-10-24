<?php

namespace App\Models;

use App\Models\Room\Invitation;
use App\Models\Room\Room;
use App\Models\Room\WaitingRoom;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 *
 * @mixin Builder
 * @property int id
 * @property string username
 * @property string name
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string phone_number
 * @property string password
 * @property string email_verified_at
 * @property bool phone_number_verified
 * @property bool dark_mode
 * @property string created_at
 * @property string updated_at
 *
 * @property Room[] rooms
 * @property Room[] ownedRooms
 * @property Room[] adminRooms
 * @property Room[] guestRooms
 * @property WaitingRoom[] waitingRooms
 *
 * @property array split_rooms
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'username' => 'string',
        'name' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'phone_number' => 'string',
        'email_verified_at' => 'datetime',
        'phone_number_verified' => 'boolean',
        'dark_mode' => 'boolean',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all rooms associated with the user.
     *
     * @return BelongsToMany
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)->withPivot('role');
    }

    public function invitations(): HasMany|Invitation
    {
        return $this->hasMany(Invitation::class, 'invitee_id');
    }

    public function sentInvitations(): HasMany|Invitation
    {
        return $this->hasMany(Invitation::class, 'inviter_id');
    }

    /**
     * Get rooms owned by the user.
     *
     * @return BelongsToMany
     */
    public function ownedRooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->wherePivot('role', 'owner');
    }

    /**
     * Get rooms where the user is an admin.
     *
     * @return BelongsToMany
     */
    public function adminRooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->wherePivot('role', 'admin');
    }

    /**
     * Get rooms where the user is a guest.
     *
     * @return BelongsToMany
     */
    public function guestRooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->wherePivot('role', 'guest');
    }

    /**
     * Get waiting rooms associated with the user.
     *
     * @return BelongsToMany
     */
    public function waitingRooms(): BelongsToMany
    {
        return $this->belongsToMany(
            WaitingRoom::class,
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

    /**
     * Get all rooms associated with the user, split by role.
     *
     * @return array An associative array containing rooms split by role:
     *               - 'ownedRooms': Rooms owned by the user
     *               - 'adminRooms': Rooms where the user is an admin
     *               - 'guestRooms': Rooms where the user is a guest
     *               - 'waitingRooms': Waiting rooms associated with the user
     */
    public function getSplitRoomsAttribute(): array
    {
        return [
            'ownedRooms' => $this->ownedRooms,
            'adminRooms' => $this->adminRooms,
            'guestRooms' => $this->guestRooms,
            'waitingRooms' => $this->waitingRooms,
        ];
    }
}