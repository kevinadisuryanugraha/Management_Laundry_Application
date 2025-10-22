@extends('app')
@section('title', 'Manajemen User')

@section('content')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white"><i class="bi bi-people-fill me-2 text-white"></i> Manajemen User</h5>
            <a href="{{ url('user/create') }}" class="btn btn-light btn-sm">
                Tambah User
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="userTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 25%">Nama</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 15%">Role</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="badge bg-{{ $role->name == 'Admin' ? 'primary' : ($role->name == 'Kasir' ? 'success' : 'secondary') }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="btn btn-outline-success btn-sm me-1" data-bs-toggle="tooltip"
                                        title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="tooltip" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="bi bi-exclamation-circle"></i> Tidak ada data user
                                </td>
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
            $('#userTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "language": {
                    "search": "Cari:",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    },
                    "emptyTable": "Tidak ada data user"
                }
            });

            // Aktifkan tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
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
