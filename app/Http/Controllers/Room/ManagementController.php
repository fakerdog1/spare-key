<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ManagementController extends Controller
{
    public function index(): View
    {
        $authUser = auth()->user();

        return view('room.my-rooms.index', [
            'rooms' => $authUser->split_rooms,
        ]);
    }
}
