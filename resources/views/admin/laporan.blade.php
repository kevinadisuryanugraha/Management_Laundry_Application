@extends('app')
@section('title', 'Laporan Transaksi')

@section('content')
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white"><i class="bi bi-receipt"></i> Laporan Transaksi</h4>
            @if (request('start_date') && request('end_date'))
                <span class="badge bg-light text-dark px-3 py-2">
                    Periode: {{ request('start_date') }} s/d {{ request('end_date') }}
                </span>
            @endif
        </div>

        <div class="card-body">
            {{-- Filter Tanggal --}}
            <form method="GET" action="{{ route('laporan.transaksi') }}" class="row g-3 align-items-end mb-4 mt-2">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <a href="{{ route('laporan.transaksi') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('laporan.transaksi.cetak') }}" target="_blank" class="btn btn-success w-100">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Cetak Laporan
                    </a>
                </div>
            </form>

            {{-- Tabel Laporan --}}
            <div class="table-responsive">
                <table id="memberTable" class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Member</th>
                            <th>Tanggal Masuk</th>
                            <th>Estimasi</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $row->nomor_transaksi }}</span></td>
                                <td>{{ $row->member->nama_member ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_masuk)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->estimasi_selesai)->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $row->status == 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($row->dibayar == 'sudah')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Belum</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($row->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">🚫 Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "language": {
                    "search": "Cari:",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    },
                    "emptyTable": "Tidak ada data transaksi"
                }
            });
        });
    </script>
@endpush
