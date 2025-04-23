<?php

namespace App\Http\Controllers;

use App\Models\rooms;
use App\Models\room_type;
use Illuminate\Http\Request;

class RoomsController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = rooms::with('room_type')->get();
        return view('admin.kamar', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $room_types = room_type::all();
        return view('kamar.create', compact('room_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required',
            'room_number' => 'required',
            'room_status' => 'required',
        ]);

        rooms::create([
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->room_number,
            'room_status' => $request->room_status,
        ]);

        return redirect(route('kamar.index'))
        ->with('success', 'Jenis Kamar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(rooms $rooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rooms $rooms)
    {
        $room_types = room_type::all();
        return view('kamar.edit', compact('rooms', 'room_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rooms $rooms)
    {
        $request->validate([
            'room_type_id' => 'required',
            'room_number' => 'required',
            'room_status' => 'required',
        ]);

        $rooms->update([
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->room_number,
            'room_status' => $request->room_status,
        ]);
        return redirect()->route('kamar.index')
        ->with('success','Kamar berhasil diubah');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rooms $rooms)
    {
        $rooms->delete();
        return redirect()->route('kamar.index');
    }


}
