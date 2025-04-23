@extends('dashboard')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Jenis Kamar</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('jeniskamar.update', $room_type->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputName">Tipe Kamar</label>
                            <input type="text" id="inputName" name="tipe_kamar" class="form-control" value="{{$room_type->tipe_kamar}}" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Deskripsi</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">{{old('description', $room_type->description)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Price</label>
                            <input type="file" id="price" name="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        <!-- Tombol Save -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Edit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
@endsection
