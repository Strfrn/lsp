<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room_type;
use App\Models\rooms;

class FrontendController extends Controller
{
    public function rooms()
    {
        $room_types = room_type::with('rooms')->get();
        return view('user.index', compact('room_types'));
    }

    public function ruangan()
    {
        $room_types = room_type::with('rooms')->get();
        return view('user.rooms', compact('room_types'));
    }

}
