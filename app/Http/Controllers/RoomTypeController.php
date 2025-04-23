<?php

namespace App\Http\Controllers;

use App\Models\room_type;
use App\Models\reservations;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\rooms;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $room_types = room_type::all();
        return view('admin.jeniskamar', compact('room_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jeniskamar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe_kamar' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('room_type', 'public');

        room_type::create([
            'tipe_kamar' => $request->tipe_kamar,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('jeniskamar.index')
            ->with('success', 'Jenis Kamar berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(room_type $room_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(room_type $room_type)
    {
        return view('jeniskamar.edit', compact('room_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, room_type $room_type)
    {
        $request->validate([
            'tipe_kamar' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room_type->update([
            'tipe_kamar' => $request->tipe_kamar,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('room_type', 'public');
            $room_type->update(['image' => $imagePath]);
        }


        return redirect()->route('jeniskamar.index')
            ->with('success','Jenis Kamar berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(room_type $room_type)
    {
        $room_type->delete();
        return redirect()->route('jeniskamar.index')
            ->with('success','Jenis kamar berhasil dihapus');
    }

    public function jkamar($id)
    {
        $kamar = rooms::with('room_type')->findOrFail($id);

        $bookedDates = reservations::where('room_id', $id)
            ->where('status', 'approved')
            ->get()
            ->flatMap(function ($reservation) {
                $checkIn = Carbon::parse($reservation->check_in);
                $checkOut = Carbon::parse($reservation->check_out);

                $period = CarbonPeriod::create($checkIn, $checkOut);

                return collect($period)->map(function ($date) {
                    return $date->format('Y-m-d');
                });
            })
            ->unique()
            ->values()
            ->toArray();

        return view('user.kamar_show', compact('kamar', 'bookedDates'));
    }



}
