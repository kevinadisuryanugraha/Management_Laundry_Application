@extends('app')
@section('title', 'Transaksi')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manage Transaksi</h4>
                <div>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                    <a href="{{ route('transaksi.restore') }}" class="btn btn-warning">Restore</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table id="transaksiTable" class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nomor Transaksi</th>
                                <th>Member</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($transaksis as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nomor_transaksi }}</td>
                                    <td>{{ $item->member->nama_member }}</td>
                                    <td>{{ $item->tanggal_masuk }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->status == 'pending' ? 'secondary' : ($item->status == 'proses' ? 'info' : ($item->status == 'selesai' ? 'success' : 'dark')) }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->dibayar == 'sudah' ? 'success' : 'danger' }}">
                                            {{ ucfirst($item->dibayar) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('transaksi.show', $item->id) }}"
                                            class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('transaksi.edit', $item->id) }}"
                                            class="btn btn-success btn-sm">Edit</a>
                                        <a href="{{ route('transaksi.print', $item->id) }}"
                                            class="btn btn-primary btn-sm">Struk</a>
                                        {{-- Tombol Invoice --}}
                                        <form action="{{ route('transaksi.softdelete', $item->id) }}" method="post"
                                            style="display:inline"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#transaksiTable').DataTable();

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
@endpush
