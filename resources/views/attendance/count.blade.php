@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/dashboard" class="">Home</a></li>
                            <li class="breadcrumb-item active">
                                Count Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="card">
                    <div class="card-header w-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>Check Total Attendance</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('attendance.count') }}" method="POST" target="_blank">
                            @csrf
                            <div class="form-group d-flex align-items-center">
                                <label for="date" style="margin-right: 10px;">Select Date:</label>
                                <input type="date" id="date" name="date" class="form-control w-auto"
                                    style="width: 250px; margin-right: 10px;" value="{{ date('Y-m-d') }}" required>
                                <button type="submit" class="btn btn-primary">Check Attendance</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
                                    Count
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
                                                <form id="countForm{{ $event->event_id }}"
                                                    action="{{ route('attendance.count') }}" method="POST" target="_blank">
                                                    @csrf
                                                    <label for="start_date{{ $event->event_id }}" class="form-label">Tanggal
                                                        Kehadiran</label>
                                                    <input type="date" id="date" name="date" class="form-control"
                                                        value="{{ date('Y-m-d') }}" required>
                                                    <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="event.preventDefault(); document.getElementById('countForm{{ $event->event_id }}').submit();">Count
                                                    Attendance</button>
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
