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
                                Dashboard</li>
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
                <div class="col-md-4">
                    <img src="{{ asset('app/' . $userEvent->logo_file) }}" alt="Speaker 1" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="details">
                        <h2>{{ $userEvent->event_name }}</h2>
                    </div>
                    <div class="card overflow-hidden">
                        <div class="card-body d-flex align-items-center justify-content-between">

                            <div
                                class="flex-shrink-0 size-60 bg-black text-white me-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-check fs-3"></i>
                            </div>
                            <div class="flex-grow-1 text-start">
                                <h5 class="fs-4 d-block mb-1" data-aos data-aos-id="countup:in"
                                    data-to="{{ $registrationTotal ?? 0 }}" data-countup='{"startVal":"0"}'>
                                    0
                                </h5>
                                <p class="mb-0 text-muted">Registrations Events</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-sm-6 mb-4">
                    <!-- Card-->


                </div>






            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
