@extends('app')
@section('title', 'Create Transaksi')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Create Transaksi</h4>
            </div>

            @foreach ($errors->all() as $i)
                <ul style="background-color: red ">
                    <li>{{ $i }}</li>
                </ul>
            @endforeach

            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('transaksi.store') }}" method="post">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                {{-- Nomor Transaksi --}}
                                <div class="col-md-4">
                                    <label>No Transaksi</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <input type="text" class="form-control" name="nomor_transaksi"
                                        value="{{ $code }}" readonly>
                                </div>

                                {{-- Member --}}
                                <div class="col-md-4">
                                    <label>Member</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <select name="member_id" class="form-control">
                                        <option value="">-- Pilih Member --</option>
                                        @foreach ($members as $m)
                                            <option value="{{ $m->id }}"
                                                {{ old('member_id') == $m->id ? 'selected' : '' }}>
                                                {{ $m->nomor_member }} - {{ $m->nama_member }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Layanan Dinamis --}}
                                <div class="col-md-12 mb-2">
                                    <label>Layanan</label>
                                    <div id="layananContainer">
                                        <div class="row mb-2 layanan-row">
                                            <div class="col-md-7">
                                                <select name="layanan_id[]" class="form-control">
                                                    <option value="">-- Pilih Layanan --</option>
                                                    @foreach ($layanans as $l)
                                                        <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" step="0.01" class="form-control" name="qty[]"
                                                    placeholder="Qty">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-layanan">-</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-1" id="addLayanan">Tambah
                                        Layanan +</button>
                                </div>

                                <div class="col-md-4">
                                    <label>Berat (Kg/Pcs)</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <input type="number" step="0.01" class="form-control" name="berat"
                                        value="{{ old('berat') }}">
                                </div>

                                {{-- Tanggal Masuk --}}
                                <div class="col-md-4">
                                    <label>Tanggal Masuk</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <input type="date" class="form-control" name="tanggal_masuk"
                                        value="{{ old('tanggal_masuk') }}">
                                </div>

                                <div class="col-md-4">
                                    <label>Estimasi Selesai</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <input type="date" class="form-control" name="estimasi_selesai"
                                        value="{{ old('estimasi_selesai') }}">
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <label>Status</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <select name="status" class="form-control">
                                        <option value="pending" selected>Pending</option>
                                        <option value="proses">Proses</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="diambil">Diambil</option>
                                    </select>
                                </div>

                                {{-- Status Pembayaran --}}
                                <input type="hidden" name="dibayar" value="belum">

                                {{-- Catatan --}}
                                <div class="col-md-4">
                                    <label>Catatan</label>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <textarea name="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
                                </div>

                                {{-- Tombol --}}
                                <div class="col-12 d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit & Bayar</button>
                                    <a href="{{ route('transaksi.index') }}"
                                        class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addLayanan');
            const container = document.getElementById('layananContainer');

            addBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.classList.add('row', 'mb-2', 'layanan-row');
                row.innerHTML = `
            <div class="col-md-7">
                <select name="layanan_id[]" class="form-control">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($layanans as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" class="form-control" name="qty[]" placeholder="Qty">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-layanan">-</button>
            </div>`;
                container.appendChild(row);
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-layanan')) {
                    e.target.closest('.layanan-row').remove();
                }
            });
        });
    </script>
@endpush
