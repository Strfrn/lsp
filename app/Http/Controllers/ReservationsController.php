<?php

namespace App\Http\Controllers;

use App\Models\reservations;
use App\Models\rooms;
use App\Models\room_type;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_person' => 'required|integer|min:1',
            'room_id' => 'required|exists:rooms,id'
        ]);


        $conflict = reservations::where('room_id', $request->room_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                  ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                  });
        })->exists();


            if ($conflict) {
                return back()->with('error', 'pilih tanggal lain');
            }

            reservations::create([
                'room_id' => $request->room_id,
                'user_id' => auth()->id(),
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total_person' => $request->total_person,
            ]);

        return redirect()->route('history');
    }

    /**
     * Display the specified resource.
     */
    public function show(reservations $reservations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reservations $reservations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reservations $reservations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reservations $reservations)
    {
        //
    }

    public function detail()
    {
        $reservations = reservations::with('room')
            ->where('user_id', auth()->id())
            ->latest('check_in')
            ->first();

        return view('user.detail', compact('reservations'));
    }

    public function history()
    {
        $reservations = reservations::with('room', 'room_type')->where('user_id', auth()->id())->get();

        return view('user.history', compact(    'reservations'));

    }

    public function pay($id)
    {
        $reservation = reservations::findOrFail($id);

        if ($reservation->status !== 'approved') {
            $reservation->status = 'approved';
            $reservation->save();
        }

        // Redirect kembali ke halaman history dengan pesan sukses
        return redirect()->route('history')->with('success', 'Pembayaran berhasil diproses!');

    }

    public function cancel($id)
    {
        $reservation = reservations::findOrFail($id);
        if ($reservation->status !== 'approved') {
            $reservation->status = 'cancelled';
            $reservation->save();
        }

        return redirect()->route('history')->with('success', 'berhasil dibatalkan');
    }


}
