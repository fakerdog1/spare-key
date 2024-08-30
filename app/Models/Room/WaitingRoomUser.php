<?php

namespace App\Models\Room;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class WaitingRoomUser
 * @package App\Models\Room
 *
 * @mixin Builder
 * @property int $id
 * @property int $waiting_room_id
 * @property int $user_id
 * @property string $status
 * @property string $request_message
 * @property string $response_message
 * @property Carbon $requested_at
 * @property Carbon $responded_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WaitingRoomUser extends Model
{
    use HasFactory;

    protected $table = 'waiting_room_users';

    protected $fillable = [
        'waiting_room_id',
        'user_id',
        'status',
        'request_message',
        'response_message',
        'requested_at',
        'responded_at',
    ];

    protected $casts = [
        'waiting_room_id' => 'integer',
        'user_id' => 'integer',
        'status' => 'string',
        'request_message' => 'string',
        'response_message' => 'string',
        'requested_at' => 'datetime',
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** @noinspection PhpUnused */
    public function waitingRoom(): BelongsTo
    {
        return $this->belongsTo(WaitingRoom::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}