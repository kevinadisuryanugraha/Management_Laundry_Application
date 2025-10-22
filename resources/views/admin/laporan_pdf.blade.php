<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
    </style>
</head>

<body>
    <h3 style="text-align:center;">Laporan Transaksi</h3>
    <table>
        <thead>
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
            @foreach ($transaksi as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->nomor_transaksi }}</td>
                    <td>{{ $row->member->nama_member ?? '-' }}</td>
                    <td>{{ $row->tanggal_masuk }}</td>
                    <td>{{ $row->estimasi_selesai }}</td>
                    <td>{{ ucfirst($row->status) }}</td>
                    <td>{{ $row->dibayar == 'sudah' ? 'Lunas' : 'Belum' }}</td>
                    <td>Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
