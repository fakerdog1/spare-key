<?php

namespace App\Models\Room;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class WaitingRoom
 * @package App\Models\Room
 *
 * @mixin Builder
 * @property int $id
 * @property int $room_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WaitingRoom extends Model
{
    use HasFactory;

    protected $table = 'waiting_rooms';

    protected $fillable = [
        'room_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'room_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function users(): BelongsToMany
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
}