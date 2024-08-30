<?php

namespace App\Observers;

use App\Models\Room\Room;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        $this->attachOwnerTo($room);
        $this->createWaitingRoomFor($room);
    }

    /**
     * @param Room $room
     * @return void
     */
    public function createWaitingRoomFor(Room $room): void
    {
        $room->waitingRoom()->create();
    }

    /**
     * @param Room $room
     * @return void
     */
    public function attachOwnerTo(Room $room): void
    {
        $room->users()->attach(auth()->id(), ['role' => 'owner']);
    }
}