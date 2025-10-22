@extends('app')
@section('title', 'Dashboard')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah User</h4>
            </div>

            @foreach ($errors->all() as $i)
                <ul style="background-color: red ">
                    <li>{{ $i }}</li>
                </ul>
            @endforeach

            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('user.store') }}" method="post">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                {{-- Username --}}
                                <div class="col-md-4">
                                    <label>Username</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" placeholder="Masukkan Username">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" placeholder="Masukkan Email">
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-4">
                                    <label>Password</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Masukkan Password">
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-md-4">
                                    <label>Konfirmasi Password</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="Ulangi Password">
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Role --}}
                                <div class="col-md-4">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <select name="role" class="form-control" required>
                                                <option value="">-- Pilih Role --</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-shield-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    <a href="{{ route('user.index') }}"
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
