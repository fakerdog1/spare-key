<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Room\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManagementController extends Controller
{
    public function index() {
        $authUser = auth()->user();

        return view('room.my-rooms.index', [
            'rooms' => $authUser->split_rooms,
        ]);
    }
}
