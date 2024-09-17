@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/" class="">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a href="#" class="">Advance</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Logbook</li>
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
                            <span>Acitivity Log</span>
                        </div>
                    </div>
                    <div class="card-body w-100 overflow-scroll">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
