@extends('dashboard')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Reservasi</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('reservasi.update', $reservation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="inputName">Tipe Kamar</label>
                            <select id="room_type_id" name="room_type_id" class="form-control" required>
                                <option value="">Pilih Jenis Kamar</option>
                                @foreach($room_types as $room_type)
                                <option value="{{ $room_type->id }}"
                                    {{ old('room_type_id', $reservation->room->room_type->id) == $room_type->id ? 'selected' : '' }}>
                                    {{ $room_type->tipe_kamar }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputroomnumber">No. Kamar</label>
                            <input type="text" id="inputroomnumber" name="roomnumber" class="form-control"
                                value="{{ old('roomnumber', $reservation->room->room_number) }}">
                        </div>

                        <div class="form-group">
                            <label for="checkin">Check-in</label>
                            <input type="date" id="checkin" name="checkin" class="form-control"
                                value="{{ old('checkin', \Carbon\Carbon::parse($reservation->check_in)->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label for="checkout">Check-out</label>
                            <input type="date" id="checkout" name="checkout" class="form-control"
                                value="{{ old('checkout', \Carbon\Carbon::parse($reservation->check_out)->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label for="totalprice">Total Price</label>
                            <input type="text" id="totalprice" name="totalprice" class="form-control"
                                value="{{ old('totalprice', $reservation->totalprice ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>cancelled</option>
                                <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>

@endsection
