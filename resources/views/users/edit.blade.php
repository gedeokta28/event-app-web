@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a class="" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a class="" href="{{ route('users.index') }}">User Admin</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit</li>
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
                <form class="card" method="POST" enctype="multipart/form-data"
                    action="{{ route('users.update', ['user' => $user?->user_id]) }}">
                    <div class="card-header w-100">
                        Edit User
                    </div>
                    <div class="card-body">
                        @method('PUT')
                        @csrf

                        <div class="text-muted col-12 flex align-items-center my-3">
                            <span>User Detail</span>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="user_name">User Name</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('user_name') is-invalid @enderror" id="user_name"
                                    name="user_name" type="text" maxlength="100" value="{{ $user->user_name }}">
                                @error('user_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="user_password">Password</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('user_password') is-invalid @enderror" id="user_password"
                                    name="user_password" type="password" maxlength="100">
                                @error('user_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <!-- Events Selection (Multiple Select) -->
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_ids">Pilih Event</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <select id="event_ids" class="form-select @error('event_ids') is-invalid @enderror"
                                    name="event_ids[]">
                                    @foreach ($events as $event)
                                        <option value="{{ $event->event_id }}" @selected($userEvent->event_id == $event->event_id)>
                                            {{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a class="btn btn-danger" type="button" href="{{ route('users.index') }}">Batal</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <script src="https://cdn.tiny.cloud/1/j5dtvkz76wl4jfu85t73jd3rtatnhh5x5e9wigtuzqohjvv3/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://unpkg.com/imask"></script>
@endpush

@push('scripts')
@endpush
