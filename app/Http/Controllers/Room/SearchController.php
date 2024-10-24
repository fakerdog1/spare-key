<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Room\Room;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $rooms = new Room();
        $rooms = $rooms->where('date_from', '<=', now())
            ->where('date_to', '>=', now())
            ->get()
            ->filter(function ($room) {
                return $room->spare_keys_left > 0;
            });

        return view('room.search', [
            'rooms' => $rooms,
        ]);
    }
}
