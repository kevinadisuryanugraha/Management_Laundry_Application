@extends('app')
@section('title', 'Laporan Keuangan')
@section('content')
    <div class="col-md-12">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">📊 Laporan Keuangan</h4>
                <span class="badge bg-light text-dark px-3 py-2">Periode: {{ $bulan }}/{{ $tahun }}</span>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <form method="GET" action="{{ route('laporan.keuangan') }}" class="mb-4 mt-2">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="Bulan" class="form-label fw-bold">Bulan</label>
                            <input type="number" name="bulan" class="form-control" value="{{ $bulan }}"
                                min="1" max="12">
                        </div>
                        <div class="col-md-3">
                            <label for="Tahun" class="form-label fw-bold">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-end gap-2">
                            <button class="btn btn-primary w-50">
                                <i class="bi bi-funnel-fill"></i> Filter
                            </button>
                            <a href="{{ route('laporan.keuangan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                                class="btn btn-success w-50">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table id="memberTable" class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Member</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-secondary">{{ $row->nomor_transaksi }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($row->tanggal_masuk)->format('d M Y') }}</td>
                                    <td>{{ $row->member->nama_member }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($row->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">🚫 Tidak ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="alert alert-success mt-3">
                    <h5 class="mb-0 text-white">💰 Total: <span class="fw-bold">Rp
                            {{ number_format($total, 0, ',', '.') }}</span>
                    </h5>
                </div>

                <!-- Chart -->
                <div class="mt-5">
                    <h5 class="mb-3">📈 Grafik Pemasukan Harian</h5>
                    <div id="chartKeuangan" class="border rounded shadow-sm p-2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable(); // aktifkan datatables
        });

        var chartDataCandlestick = [
            @foreach ($chartData as $tanggal => $total)
                {
                    x: "{{ $tanggal }}",
                    y: [
                        {{ $total }},
                        {{ $total }},
                        {{ $total }},
                        {{ $total }}
                    ]
                },
            @endforeach
        ];

        var options = {
            chart: {
                type: 'candlestick',
                height: 450,
                background: '#1e1e2f', // background gelap ala TradingView
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        pan: true,
                        reset: true
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 600
                }
            },
            series: [{
                data: chartDataCandlestick
            }],
            xaxis: {
                type: 'category',
                labels: {
                    rotate: -45,
                    style: {
                        colors: '#fff',
                        fontSize: '12px'
                    }
                },
                axisBorder: {
                    show: true,
                    color: '#888'
                },
                axisTicks: {
                    show: true,
                    color: '#888'
                }
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    formatter: function(val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    },
                    style: {
                        colors: '#fff',
                        fontSize: '12px'
                    }
                },
                axisBorder: {
                    show: true,
                    color: '#888'
                },
                axisTicks: {
                    show: true,
                    color: '#888'
                }
            },
            grid: {
                borderColor: '#444',
                row: {
                    colors: ['transparent'], // grid tipis
                },
                column: {
                    colors: ['transparent']
                }
            },
            plotOptions: {
                candlestick: {
                    colors: {
                        upward: '#00E396', // hijau untuk naik
                        downward: '#FF4560' // merah untuk turun
                    },
                    wick: {
                        useFillColor: true
                    }
                }
            },
            tooltip: {
                enabled: true,
                shared: true,
                custom: function({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex].y;
                    return '<div style="padding:5px;color:#fff;background:#2b2b3b;border-radius:5px;">' +
                        '<strong>Open:</strong> Rp ' + data[0].toLocaleString('id-ID') + '<br/>' +
                        '<strong>High:</strong> Rp ' + data[1].toLocaleString('id-ID') + '<br/>' +
                        '<strong>Low:</strong> Rp ' + data[2].toLocaleString('id-ID') + '<br/>' +
                        '<strong>Close:</strong> Rp ' + data[3].toLocaleString('id-ID') +
                        '</div>';
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartKeuangan"), options);
        chart.render();
    </script>
@endpush
