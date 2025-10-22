@extends('app')
@section('title', 'Manage Layanan')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Manage Layanan</div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <a href="{{ url('layanan/create') }}" class="btn btn-primary mt-2 mb-2">Create</a>
                    <a href="{{ url('layanan/restore') }}" class="btn btn-warning mt-2 mb-2">Restore</a>
                    <table id="layananTable" class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($layanans as $layanan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ number_format($layanan->harga, 0, ',', '.') }}</td>
                                    <td>{{ $layanan->satuan }}</td>
                                    <td>{{ $layanan->deskripsi }}</td>
                                    <td>
                                        <a href="{{ route('layanan.edit', $layanan->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('layanan.softdelete', $layanan->id) }}" method="post"
                                            style="display:inline" onsubmit="return confirm('Ingin delete ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
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
            $('#layananTable').DataTable(); // aktifkan datatables
        });

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
    </script>
@endpush
