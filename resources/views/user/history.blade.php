<!-- Tambahkan ini di dalam <head> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tambahkan ini sebelum penutupan </body> untuk mengaktifkan JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <div class="container py-5">
        <!-- Tombol Back -->
        <div class="mb-4">
            <a href="{{ route('rooms') }}" class="btn btn-outline-secondary">
                ← Kembali ke Home
            </a>
        </div>

        <h2 class="mb-4">Riwayat Pemesanan</h2>

        <div class="row">
            @forelse($reservations as $reservation)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100 border rounded-4 overflow-hidden">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                {{-- <h5 class="card-title">{{$reservation->room->room_type->tipe_kamar}}</h5><br> --}}
                                <p class="card-text mb-1"><strong>Nomor Kamar:</strong> {{ $reservation->room->room_number }}</p>
                                <p class="card-text mb-1"><strong>Check-In:</strong> {{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }}</p>
                                <p class="card-text mb-1"><strong>Check-Out:</strong> {{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}</p>
                                <p class="card-text">
                                    <strong>Status:</strong>
                                    <span class="badge
                                    @if($reservation->status === 'approved') bg-success text-white
                                    @elseif($reservation->status === 'cancelled') bg-danger text-white
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                                </p>
                            </div>

                            @if($reservation->status == 'pending')
                            <button
                                class="btn btn-outline-success mt-3"
                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal{{ $reservation->id }}">
                                Bayar Sekarang
                            </button>
                        @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Pembayaran -->
                <div class="modal fade" id="paymentModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Total Bayar:</strong> Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Form Bayar -->
                                <form action="{{ route('bayar', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Lanjut Bayar</button>
                                </form>

                                <!-- Form Cancel -->
                                <form action="{{ route('cancel', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancel Pesanan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center rounded-3">
                        Kamu belum memiliki riwayat pemesanan.
                    </div>
                </div>
            @endforelse
        </div>
    </div>


