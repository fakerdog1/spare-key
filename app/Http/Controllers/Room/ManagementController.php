<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;

class ManagementController extends Controller
{
    public function index() {
        $authUser = auth()->user();

        return view('room.my-rooms.index', [
            'rooms' => $authUser->split_rooms,
        ]);
    }
}
