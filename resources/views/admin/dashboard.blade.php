@extends('app')
@section('title', 'Dashboard')
@section('content')
    <section class="row">

        <!-- Main Content -->
        <div class="col-12 col-lg-12">
            <div class="row g-3">

                {{-- Pendapatan full-width --}}
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0" style="font-size: 0.8rem">Pendapatan</h6>
                                <h5 class="mb-0">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Field lainnya: Total Transaksi, Total Member, Layanan Populer --}}
                @php
                    $otherStats = [
                        [
                            'label' => 'Total Transaksi',
                            'value' => $totalTransaksi ?? 0,
                            'icon' => 'bi-receipt',
                            'bg' => 'primary',
                        ],
                        [
                            'label' => 'Total Member',
                            'value' => $totalMember ?? 0,
                            'icon' => 'bi-people',
                            'bg' => 'warning',
                        ],
                        [
                            'label' => 'Layanan Populer',
                            'value' => $layananPopulerName ?? '-',
                            'icon' => 'bi-star',
                            'bg' => 'danger',
                        ],
                    ];
                @endphp

                @foreach ($otherStats as $stat)
                    <div class="col-12 col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-{{ $stat['bg'] }} text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi {{ $stat['icon'] }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0" style="font-size: 0.8rem">{{ $stat['label'] }}</h6>
                                    <h5 class="mb-0">{{ $stat['value'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>


            <!-- Grafik Pendapatan Harian -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">📈 Pendapatan Harian</h5>
                        </div>
                        <div class="card-body">
                            <div id="chartPendapatan"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Pendapatan Bulanan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h5 class="mb-0">📊 Pendapatan Bulanan</h5>
                        </div>
                        <div class="card-body">
                            <div id="chartPendapatanBulan"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h5 class="mb-0">📝 Transaksi Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Transaksi</th>
                                            <th>Member</th>
                                            <th>Layanan</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transaksiTerbaru as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->nomor_transaksi }}</td>
                                                <td>{{ $row->member->nama_member }}</td>
                                                <td>
                                                    @foreach ($row->layanan as $l)
                                                        <span class="badge bg-info">{{ $l->nama_layanan }}</span>
                                                    @endforeach
                                                </td>
                                                <td>Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $row->dibayar == 'sudah' ? 'success' : 'warning' }}">
                                                        {{ $row->dibayar == 'sudah' ? 'Lunas' : 'Belum Bayar' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Tidak ada transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var optionsHarian = {
            chart: {
                type: 'area',
                height: 300
            },
            series: [{
                name: 'Pendapatan Harian',
                data: {!! json_encode(array_values($chartPendapatan->toArray())) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_keys($chartPendapatan->toArray())) !!}
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            }
        };
        var chartHarian = new ApexCharts(document.querySelector("#chartPendapatan"), optionsHarian);
        chartHarian.render();

        var optionsBulan = {
            chart: {
                type: 'bar',
                height: 300
            },
            series: [{
                name: 'Pendapatan Bulanan',
                data: {!! json_encode(array_values($chartPendapatanBulan->toArray())) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_keys($chartPendapatanBulan->toArray())) !!}
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            },
            dataLabels: {
                enabled: false
            }
        };
        var chartBulan = new ApexCharts(document.querySelector("#chartPendapatanBulan"), optionsBulan);
        chartBulan.render();
    </script>
@endpush
