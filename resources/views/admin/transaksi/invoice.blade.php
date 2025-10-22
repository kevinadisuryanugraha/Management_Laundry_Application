@extends('app')
@section('title', 'Struk Transaksi')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div id="struk" class="card-body p-3 dashed-border"
                style="max-width:400px; margin:auto; font-family:monospace; border:1px dashed #000;">
                {{-- Header --}}
                <div class="text-center mb-2">
                    <h4>LAUNDRY MA-VINS</h4>
                    <p>Jl. Contoh No. 123, Jakarta</p>
                    <hr>
                </div>

                {{-- Info Transaksi --}}
                <div class="mb-2">
                    <p>No Transaksi: <strong>{{ $transaksi->nomor_transaksi }}</strong></p>
                    <p>Member: <strong>{{ $transaksi->member->nama_member }}</strong></p>
                    <p>Tanggal: <strong>{{ $transaksi->tanggal_masuk }}</strong></p>
                    <p>Estimasi Selesai: <strong>{{ $transaksi->estimasi_selesai }}</strong></p>

                    {{-- Barcode --}}
                    <div style="text-align:center; margin:10px 0;">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($transaksi->nomor_transaksi, 'C39', 1.5, 50) }}"
                            alt="barcode" style="display:block; margin:auto; max-width:80%; height:auto;" />
                        <div style="font-size:12px; margin-top:5px;">{{ $transaksi->nomor_transaksi }}</div>
                    </div>
                    <hr>
                </div>

                {{-- Daftar Layanan --}}
                <table style="width:100%; font-size:14px; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; border-bottom:1px dashed #000;">Item</th>
                            <th style="text-align:center; border-bottom:1px dashed #000;">Qty</th>
                            <th style="text-align:right; border-bottom:1px dashed #000;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($transaksi->layanan as $detail)
                            <tr>
                                <td style="border-bottom:1px dashed #000;">{{ $detail->nama_layanan }}</td>
                                <td style="text-align:center; border-bottom:1px dashed #000;">{{ $detail->pivot->qty }}</td>
                                <td style="text-align:right; border-bottom:1px dashed #000;">
                                    Rp {{ number_format($detail->pivot->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @php $total += $detail->pivot->subtotal; @endphp
                        @endforeach
                    </tbody>
                </table>
                <hr>

                {{-- Total & Status --}}
                <div style="text-align:right; font-weight:bold;">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
                <div style="text-align:center; margin-top:5px;">
                    Status Pembayaran:
                    @if ($transaksi->dibayar == 'sudah')
                        <span style="color:green;">LUNAS</span>
                    @else
                        <span style="color:red;">BELUM</span>
                    @endif
                </div>

                {{-- Catatan --}}
                @if ($transaksi->catatan)
                    <p style="font-size:12px; margin-top:5px;">Catatan: {{ $transaksi->catatan }}</p>
                @endif

                {{-- Footer --}}
                <hr>
                <div class="text-center" style="font-size:12px;">
                    Terima kasih atas kepercayaan Anda.<br>
                    Silahkan simpan struk ini sebagai bukti transaksi.
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="card-footer mt-2 text-center">
                @if ($transaksi->dibayar == 'belum')
                    <form action="{{ route('transaksi.bayar', $transaksi->id) }}" method="POST" class="mb-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Tandai Sudah Bayar</button>
                    </form>
                @endif

                <button onclick="printStruk()" class="btn btn-primary btn-sm mb-1">Print Struk</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-light btn-sm">Kembali</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function printStruk() {
            var strukContent = document.getElementById('struk').outerHTML;

            var printWindow = window.open('', '', 'height=600,width=350');
            printWindow.document.write('<html><head><title>Struk Transaksi</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body{font-family:monospace; padding:10px;}');
            printWindow.document.write('.dashed-border{border:1px dashed #000; padding:10px;}');
            printWindow.document.write('table{width:100%; border-collapse: collapse; font-size:14px;}');
            printWindow.document.write('th, td{padding:4px;}');
            printWindow.document.write('th, td{border-bottom:1px dashed #000;}');
            printWindow.document.write('hr{border:0; border-top:1px dashed #000; margin:5px 0;}');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(strukContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
@endpush
