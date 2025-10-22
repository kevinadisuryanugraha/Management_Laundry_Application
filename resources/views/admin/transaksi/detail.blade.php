@extends('app')
@section('title', 'Detail Transaksi')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-white">Detail Transaksi #{{ $transaksi->id }}</h4>
            </div>
            <div class="card-body">

                {{-- Informasi Member --}}
                <h5 class="text-secondary mb-3 mt-3">Informasi Member</h5>
                <table class="table table-sm">
                    <tr>
                        <th>Nomor Member</th>
                        <td>{{ $transaksi->member->nomor_member }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $transaksi->member->nama_member }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $transaksi->member->email }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $transaksi->member->no_hp }}</td>
                    </tr>
                </table>

                {{-- Informasi Transaksi --}}
                <h5 class="text-secondary mt-4 mb-3">Informasi Transaksi</h5>
                <table class="table table-sm">
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Estimasi Selesai</th>
                        <td>{{ $transaksi->estimasi_selesai ? \Carbon\Carbon::parse($transaksi->estimasi_selesai)->format('d M Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>{{ $transaksi->berat }} Kg</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($transaksi->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($transaksi->status == 'proses')
                                <span class="badge bg-info">Proses</span>
                            @elseif($transaksi->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($transaksi->status == 'diambil')
                                <span class="badge bg-primary">Diambil</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Pembayaran</th>
                        <td>
                            @if ($transaksi->dibayar == 'sudah')
                                <span class="badge bg-success">Sudah Dibayar</span>
                            @else
                                <span class="badge bg-danger">Belum Dibayar</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $transaksi->catatan ?? '-' }}</td>
                    </tr>
                </table>

                {{-- Detail Layanan --}}
                <h5 class="text-secondary mt-4 mb-3">Detail Layanan</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Layanan</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->details as $i => $detail)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $detail->layanan->nama_layanan }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Total</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('transaksi.invoice', $transaksi->id) }}" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Cetak Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
