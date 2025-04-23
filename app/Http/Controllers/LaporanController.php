<?php

namespace App\Http\Controllers;

use App\Models\reservations;
use Illuminate\Http\Request;
use App\Models\Reservation; // Gunakan PascalCase untuk model
use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Jika tidak ada parameter tanggal, tampilkan form kosong
        if (!$request->filled(['start_date', 'end_date'])) {
            return view('admin.laporan', [
                'reservations' => collect(),
                'totalPendapatan' => 0,
                'start' => null,
                'end' => null,
                'topRooms' => collect(),
                'showFormOnly' => true // Flag untuk menandai form saja
            ]);
        }

        // Validasi input tanggal
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $start = $validated['start_date'];
        $end = $validated['end_date'];

        // Query untuk reservasi dengan periode tertentu
        $reservations = reservations::with(['room', 'room.room_type'])
            ->where('status', 'approved')
            ->whereBetween('check_in', [$start, $end])
            ->get();

        // Hitung total pendapatan
        $totalPendapatan = $reservations->sum(function ($reservation) {
            $checkin = Carbon::parse($reservation->check_in);
            $checkout = Carbon::parse($reservation->check_out);
            $days = $checkin->diffInDays($checkout);
            return $reservation->room->room_type->price * $days;
        });

        // Query untuk kamar paling populer
        $topRooms = reservations::select('room_id', DB::raw('count(*) as total_reservasi'))
            ->where('status', 'approved')
            ->whereBetween('check_in', [$start, $end])
            ->groupBy('room_id')
            ->orderByDesc('total_reservasi')
            ->take(3)
            ->with('room.room_type')
            ->get();

        return view('admin.laporan', compact('reservations', 'totalPendapatan', 'start', 'end', 'topRooms'));
    }
}
