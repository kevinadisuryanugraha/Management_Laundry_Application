@extends('app')
@section('title', 'Restore Layanan')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Restore Layanan</div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <a href="{{ url('layanan/index') }}" class="btn btn-secondary mt-2 mb-2">Back</a>
                    <table id="layananTable" class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($layanan_r as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_layanan }}</td>
                                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        <a href="{{ route('layanan.restore', $item->id) }}"
                                            class="btn btn-warning">Restore</a>
                                        <form action="{{ route('layanan.destroy', $item->id) }}" method="post"
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
