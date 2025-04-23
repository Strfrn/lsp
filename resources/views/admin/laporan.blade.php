@extends('dashboard')
@section('content')
<div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title text-white"><i class="fas fa-file-invoice-dollar mr-2"></i>Laporan Pendapatan</h3>
    </div>

    <div class="card-body">
        <!-- Improved Top Rooms Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-gradient-info">
                <h3 class="card-title text-dark">
                    <i class="fas fa-crown mr-2"></i>Top 3 Kamar Terpopuler
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($topRooms as $index => $item)
                    <div class="list-group-item {{ $index === 0 ? 'border-top-0' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                    <h5 class="mb-0">Kamar {{ $item->room->room_number }}</h5>
                                </div>
                                <small class="text-muted">{{ $item->room->room_type->tipe_kamar }}</small>
                            </div>
                            <div>
                                <span class="badge bg-success rounded-pill p-2">
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    {{ $item->total_reservasi }}x dipesan
                                </span>
                            </div>
                        </div>
                        @if($index === 0)
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star mr-1"></i>Best Seller
                            </span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End of Improved Top Rooms Section -->

        <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required
                               value="{{ request('start_date') }}" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required
                               value="{{ request('end_date') }}" >
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        @if(isset($totalPendapatan))
        <div class="alert alert-success">
            <h4 class="alert-heading"><i class="fas fa-chart-line mr-2"></i>Ringkasan Pendapatan</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <h3 class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        @endif

        @if(isset($reservations) && $reservations->count() > 0)
        <div class="table-responsive">
            <table id="laporan-table" class="table table-bordered table-striped table-hover">
                <thead class="bg-secondary">
                    <tr>
                        <th>No</th>
                        <th>Kamar</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $key => $reservation)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $reservation->room->room_number }} ({{ $reservation->room->room_type->tipe_kamar }})</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($reservation->totalprice, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{
                                $reservation->status === 'approved' ? 'success' :
                                ($reservation->status === 'pending' ? 'warning' : 'danger')
                            }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif(request()->has('start_date'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>Tidak ada data transaksi pada periode yang dipilih.
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    $('#laporan-table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
        "buttons": [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info'
            }
        ],
        "language": {
            "search": "Cari:",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya"
            },
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "lengthMenu": "Tampilkan _MENU_ entri"
        }
    });

    // Set tanggal maksimal hari ini
    $('#start_date, #end_date').change(function() {
        if ($('#start_date').val() > $('#end_date').val()) {
            $('#end_date').val($('#start_date').val());
        }
    });
});
</script>
@endsection
