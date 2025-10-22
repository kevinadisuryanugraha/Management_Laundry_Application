@extends('app')
@section('title', 'Restore Member')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Restore Member</div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <a href="{{ route('member.index') }}" class="btn btn-secondary mt-2 mb-2">Back</a>
                    <table id="memberTable" class="table table-bordered text-center">
                        <thead>
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
                            @foreach ($member_r as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nomor_member }}</td>
                                    <td>{{ $item->nama_member }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <a href="{{ route('member.restore', $item->id) }}" class="btn btn-success btn-sm">
                                            Restore
                                        </a>
                                        <form action="{{ route('member.destroy', $item->id) }}" method="post"
                                            style="display: inline" onsubmit="return confirm('Ingin delete ?')">
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
