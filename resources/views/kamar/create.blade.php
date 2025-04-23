@extends('dashboard')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kamar</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('kamar.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="room_type_id">Jenis Kamar</label>
                            <select id="room_type_id" name="room_type_id" class="form-control" required>
                                <option value="">Pilih Jenis Kamar</option>
                                @foreach($room_types as $room_type)
                                    <option value="{{ $room_type->id }}">{{ $room_type->tipe_kamar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_number">Nomor Kamar</label>
                            <input type="text" id="room_number" name="room_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="room_status">Status</label>
                            <select id="room_status" name="room_status" class="form-control" required>
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
