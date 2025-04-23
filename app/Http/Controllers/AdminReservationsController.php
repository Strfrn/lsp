<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservations;
use App\Models\room_type;
use App\Models\rooms;

class AdminReservationsController extends Controller
{
    public function index()
    {
        $reservations = reservations::with('room_type')->get();
        return view('admin.reservasi', compact('reservations'));
    }

    public function destroy($id)
    {
        $reservation = reservations::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservasi.index')->with('success', 'reservasi berhasil dihapus');
    }

    public function edit($id)
    {
        $reservation = reservations::with('room_type')->findOrFail($id);
        $room_types = room_type::all();

        return view('reservasi.edit', compact('reservation', 'room_types'));
    }

    public function update(Request $request, $id)
    {
        $reservation = reservations::findOrFail($id);

        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'roomnumber' => 'required',
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
            'totalprice' => 'required|numeric|min:0',
            'status' => 'required|in:approved,cancelled,pending' // Sesuaikan dengan opsi form
        ]);

        $reservation->update([
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->roomnumber,
            'check_in' => $request->checkin,
            'check_out' => $request->checkout,
            'totalprice' => $request->totalprice,
            'status' => $request->status
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }


}

