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
                                <a href="{{ route('registration.index') }}" class="">Registrations</a>
                            </li>
                            <li class="breadcrumb-item active">
                                List</li>
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
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.check-in-btn', function() {
            var regId = $(this).data('reg-id');
            var button = $(this); // Save the button reference

            // Show loading state
            button.prop('disabled', true).text('Loading...'); // Change button text and disable it

            $.ajax({
                url: '{{ route('attendance.checkIn') }}', // Use named route for better practice
                method: 'POST',
                data: {
                    reg_id: regId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    alert(response.message);
                    // Refresh the DataTable
                    $('#registration-table').DataTable().ajax
                        .reload(); // Replace with your DataTable ID
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message);
                },
                complete: function() {
                    // Reset button to original state
                    button.prop('disabled', false).text('Check In'); // Change text back to original
                }
            });
        });
    </script>
@endpush
