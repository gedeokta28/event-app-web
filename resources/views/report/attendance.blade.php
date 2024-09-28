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
                                Attendance</li>
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
            <h1 class="mb-4">Pilih Event</h1>
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
                                <a href="" class="btn btn-success mt-2">Cetak
                                    Report</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('head')
    <script src="https://cdn.tiny.cloud/1/j5dtvkz76wl4jfu85t73jd3rtatnhh5x5e9wigtuzqohjvv3/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://unpkg.com/imask"></script>
@endpush
