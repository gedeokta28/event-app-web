@extends('layouts.app')
<style>
    .card {
        border: 1px solid #ddd;
        /* Light gray border */
        border-radius: 8px;
        /* Rounded corners */
    }

    .card-title {
        font-size: 1.25rem;
        /* Slightly larger font for the title */
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        /* Regular font size for the text */
    }

    .btn-primary {
        background-color: #007bff;
        /* Bootstrap primary color */
        border-color: #007bff;
        /* Matching border color */
    }
</style>
@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a class="" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a class="" href="{{ route('events.index') }}">Report</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Registration</li>
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
                @foreach ($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                <p class="card-text">
                                    {{ $event->event_location }} <br>
                                    {{ \Carbon\Carbon::parse($event->event_start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($event->event_end_date)->format('d M Y') }}
                                </p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#reportModal{{ $event->event_id }}">
                                    Cetak
                                </button>

                                <div class="modal fade" id="reportModal{{ $event->event_id }}" tabindex="-1"
                                    aria-labelledby="reportModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reportModalLabel">{{ $event->event_name }}</h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">

                                                <form id="reportForm{{ $event->event_id }}"
                                                    action="{{ route('download.registration.report') }}" method="GET">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Pilih Status
                                                            Registrasi</label>
                                                        <select class="form-select" id="status" name="status">
                                                            <option value="all">Semua Status</option>
                                                            <option value="successful">Hanya yang Berhasil</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                                    <input type="hidden" name="event_name" value="{{ $event->slug }}">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="event.preventDefault(); document.getElementById('reportForm{{ $event->event_id }}').submit();">Download
                                                    Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

@push('head')
@endpush
