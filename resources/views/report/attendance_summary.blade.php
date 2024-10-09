@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a class="" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a class=""
                                    href="{{ route('report-attendance') }}">Summary Attendance</a></li>

                            <li class="breadcrumb-item active">
                                {{ $event->event_name }}
                            </li>

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
                <div class="card">

                    {!! $dataTable->table([], true) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Scripts for DataTables -->
    {!! $dataTable->scripts() !!}
@endpush
