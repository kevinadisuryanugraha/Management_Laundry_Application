<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total {
            font-weight: bold;
            background: #eaeaea;
        }
    </style>
</head>

<body>
    <h2>Laporan Keuangan</h2>
    <h3>Bulan {{ $bulan }} Tahun {{ $tahun }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Nama Member</th>
                <th>Layanan (Qty x Harga)</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tgl Masuk</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nomor_transaksi ?? '-' }}</td>
                    <td>{{ $item->member->nama_member ?? '-' }}</td>
                    <td>
                        @foreach ($item->layanan as $layanan)
                            {{ $layanan->nama_layanan }} ({{ $layanan->pivot->qty }} x
                            Rp {{ number_format($layanan->pivot->harga, 0, ',', '.') }})<br>
                        @endforeach
                    </td>
                    <td class="right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td class="center">{{ ucfirst($item->dibayar) }}</td>
                    <td class="center">{{ $item->tanggal_masuk }}</td>
                    <td class="center">{{ $item->tanggal_selesai ?? '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="right total">Total Keseluruhan</td>
                <td class="right total">Rp {{ number_format($total, 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    <br><br>
    <div style="width: 100%; text-align: right; font-size: 12px;">
        <p>Jakarta, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <p><strong>Admin</strong></p>
        <br><br>
        <p>(________________________)</p>
    </div>
</body>

</html>
