@extends('app')
@section('title', 'Dashboard')

@section('content')
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white"><i class="bi bi-receipt"></i> Manage Member</h4>
            @if (request('start_date') && request('end_date'))
                <span class="badge bg-light text-dark px-3 py-2">
                    Periode: {{ request('start_date') }} s/d {{ request('end_date') }}
                </span>
            @endif
        </div>

        <div class="card-body">
            {{-- Filter Tanggal --}}
            <form method="GET" action="{{ route('laporan.member') }}" class="row g-3 align-items-end mb-4 mt-2">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <a href="{{ route('laporan.member') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('laporan.member.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                        target="_blank" class="btn btn-success w-100">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Cetak Member
                    </a>
                </div>
            </form>

            {{-- Tabel Laporan --}}
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="{{ url('member/create') }}" class="btn btn-primary">Create</a>
                    <a href="{{ route('member.restore.index') }}" class="btn btn-warning">Restore</a>
                </div>

                <table id="memberTable" class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>No Member</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($members as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><span class="badge bg-secondary">{{ $item->nomor_member }}</span></td>
                                <td>{{ $item->nama_member ?? '-' }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('member.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <form action="{{ route('member.softdelete', $item->id) }}" method="post"
                                        class="d-inline" onsubmit="return confirm('Ingin delete ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">🚫 Tidak ada data member</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    "emptyTable": "Tidak ada data member"
                }
            });
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
