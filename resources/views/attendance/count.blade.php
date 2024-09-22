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
    <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
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
    </div>
@endsection
