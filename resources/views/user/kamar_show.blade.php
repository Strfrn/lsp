@extends('user.kamarr') {{-- Sesuaikan dengan layout utama kamu --}}

@section('name')
<div class="container py-5">
    <h1 class="text-3xl font-bold mb-4">{{ $kamar->room_type->tipe_kamar  }}</h1>

    @if($kamar->room_type->image)
        <img src="{{ asset('storage/' . $kamar->room_type->image) }}" alt="{{ $kamar->room_type->tipe_kamar }}"  style="width: 800px; height: 576px; object-fit: cover;" class="w-full rounded-lg mb-6">
    @endif

    <div class="text-lg mb-4">
        <strong>Deskripsi:</strong><br>
        {!! nl2br(e($kamar->room_type->description)) !!}
    </div>

    <div class="text-lg mb-4">
        <strong>Harga per Malam:</strong><br
     class="price mr-1">Rp{{ number_format($kamar->room_type->price) }}
    </div>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
      Pesan
      </button>

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <form action="{{ route('reservasii.store') }}" method="POST">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Reservasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <input type="hidden" name="room_id" value="{{ $kamar->id }}">

              <div class="modal-body">
                <input type="hidden" id="booked-dates" value="{{ json_encode($bookedDates) }}">

                <div class="form-group">
                    <label for="check_in">Check-in</label>
                    <input type="date"
                           name="check_in"
                           id="check_in"
                           class="form-control datepicker"
                           required
                           min="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="check_out">Check-out</label>
                    <input type="date"
                           name="check_out"
                           id="check_out"
                           class="form-control datepicker"
                           required
                           min="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                  <label for="total_person">Jumlah Orang</label>
                  <input type="number" name="total_person" id="total_person" class="form-control" required min="1">
                </div>

              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Reservasi</button>
              </div>
              </div>
            </div>
            </div>
          </form>
        </div>
      </div>



<!-- jQuery -->
<script src="{{asset('../../plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('../../plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('../../plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('../../plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('../../dist/js/demo.js"')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedDates = JSON.parse(document.getElementById('booked-dates').value);

        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            disable: bookedDates,
            minDate: "today",
            onReady: function(selectedDates, dateStr, instance) {
                // Validasi saat datepicker dibuka
                if (bookedDates.includes(dateStr)) {
                    instance.clear();
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Validasi saat tanggal dipilih
                if (bookedDates.includes(dateStr)) {
                    instance.clear();
                    alert('Tanggal ini sudah dipesan!');
                }
            }
        });
    });
</script>

<script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.swalDefaultSuccess').click(function() {
        Toast.fire({
          icon: 'success',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultInfo').click(function() {
        Toast.fire({
          icon: 'info',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultError').click(function() {
        Toast.fire({
          icon: 'error',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultWarning').click(function() {
        Toast.fire({
          icon: 'warning',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultQuestion').click(function() {
        Toast.fire({
          icon: 'question',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });

      $('.toastrDefaultSuccess').click(function() {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultInfo').click(function() {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultError').click(function() {
        toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultWarning').click(function() {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });

      $('.toastsDefaultDefault').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultTopLeft').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'topLeft',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultBottomRight').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'bottomRight',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultBottomLeft').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'bottomLeft',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultAutohide').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          autohide: true,
          delay: 750,
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultNotFixed').click(function() {

        $(document).Toasts('create', {
          title: 'Toast Title',
          fixed: false,
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultFull').click(function() {
        $(document).Toasts('create', {
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          icon: 'fas fa-envelope fa-lg',
        })
      });
      $('.toastsDefaultFullImage').click(function() {
        $(document).Toasts('create', {
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          image: '../../dist/img/user3-128x128.jpg',
          imageAlt: 'User Picture',
        })
      });
      $('.toastsDefaultSuccess').click(function() {
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultInfo').click(function() {
        $(document).Toasts('create', {
          class: 'bg-info',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultWarning').click(function() {
        $(document).Toasts('create', {
          class: 'bg-warning',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultDanger').click(function() {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultMaroon').click(function() {
        $(document).Toasts('create', {
          class: 'bg-maroon',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


@endsection

