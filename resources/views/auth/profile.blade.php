@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/"
                                   class="">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{ route('accounts.index') }}"
                                   class="">Accounts</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">
            <div class="row">
                <form class="card mb-4"
                      action="{{ route('profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="_id"
                           value="{{ $user->id }}">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="position-relative">
                                            <div class="avatar size-140">
                                                <img class="img-fluid rounded-pill"
                                                     width="300px"
                                                     src="{{ $user->getPhotoProfile() }}"
                                                     alt="{{ $user->name }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1">
                                            {{ ucfirst($user->name) }}
                                        </h5>
                                        <small class="text-muted d-block">
                                            {{ ucfirst($user->role) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold required"
                                       for="name">Nama Lengkap</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input type="text"
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="John Doe"
                                       name="name"
                                       value="{{ $user?->name }}">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold required"
                                       for="email">Email</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input type="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="johndoe@example.com"
                                       name="email"
                                       value="{{ $user?->email }}">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold"
                                       for="password">Password</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input type="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Password"
                                       name="password">

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold"
                                       for="password">Konfirmasi Password</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input type="password"
                                       id="password"
                                       class="form-control"
                                       placeholder="Konfirmasi Password"
                                       name="password_confirmation">
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold"
                                       for="photo">Photo</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input type="file"
                                       id="photo"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       name="photo">

                                @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold required"
                                       for="photo">Role</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <select class="form-select @error('role') is-invalid @enderror"
                                        name="role">
                                    <option selected=""
                                            value="">-- Pilih Role User --
                                    </option>
                                    <option value="admin"
                                            @selected($user->role == 'admin')>Admin
                                    </option>
                                    <option value="superadmin"
                                            @selected($user->role == 'superadmin')>Superadmin
                                    </option>
                                </select>

                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold"
                                       for="verify">Verifikasi Email</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <div class="form-check cursor-not-allowed">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value="true"
                                           id="verify"
                                           name="verified_at"
                                           @disabled($user->email_verified_at)
                                           @checked($user->email_verified_at)>
                                    <label class="form-check-label"
                                           for="verify">
                                        Verifikasi Email User
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit"
                                class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
