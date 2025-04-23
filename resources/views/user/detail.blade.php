@extends('user.kamarr')
@section('name')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4 text-center">Detail Pemesanan</h2>

    <div class="p-4 rounded border border-blue-500 bg-red-500">

        <h4 class="mb-3">Informasi Pemesan</h4>
        <p><strong>Nama:</strong> {{ $reservations->user->name }}</p>
        <p><strong>Email:</strong> {{ $reservations->user->email }}</p>

        <hr style="border-width: 3px; border-color: green;">

        <h4 class="mb-3 mt-4">Informasi Kamar</h4>
        <p><strong>Jenis Kamar:</strong> {{ $reservations->room->room_type->tipe_kamar }}</p>
        <p><strong>Nomor Kamar:</strong> {{ $reservations->room->room_number }}</p>

        <hr style="border-width: 3px; border-color: green;">

        @foreach($reservasiAktif as $reservasi)
        <div class="mb-2">
            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservasi->check_in)->format('d M Y') }}</p>
            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservasi->check_out)->format('d M Y') }}</p>
            <hr>
        </div>
    @endforeach
        @php
            $days = \Carbon\Carbon::parse($reservations->check_in)->diffInDays(\Carbon\Carbon::parse($reservations->check_out));
            $pricePerNight = $reservations->room->room_type->price;
            $total = $days * $pricePerNight;
        @endphp

        <p><strong>Total Harga:</strong> Rp{{ number_format($total) }}</p>
    </div>

    <div class= "text-center mt-4 ">
        <button type="submit" class="btn btn-primary rounded">Bayar</button>
    </div>


</div>


@endsection
