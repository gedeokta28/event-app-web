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
                                <a class="" href="{{ route('events.index') }}">Events</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Create</li>
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
                <form class="card" method="POST" enctype="multipart/form-data" action="{{ route('events.store') }}">
                    <div class="card-header w-100">
                        Event Form
                    </div>
                    <div class="card-body">
                        @csrf

                        <div class="text-muted col-12 flex align-items-center my-3">
                            <span>Event Details</span>
                        </div>


                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_name">Event Name</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('event_name') is-invalid @enderror" id="event_name"
                                    name="event_name" type="text" maxlength="100" value="{{ old('event_name') }}">
                                @error('event_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_start_date">Event Date</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="event_start_time">Start Date</label>
                                        <input class="form-control @error('event_start_date') is-invalid @enderror"
                                            id="event_start_date" name="event_start_date" type="date"
                                            value="{{ old('event_start_date') }}" onchange="setMinEndDate()">
                                        @error('event_start_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="event_start_time">End Date</label>
                                        <input class="form-control @error('event_end_date') is-invalid @enderror"
                                            id="event_end_date" name="event_end_date" type="date"
                                            value="{{ old('event_end_date') }}" disabled>
                                        @error('event_end_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_location">Location</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('event_location') is-invalid @enderror"
                                    id="event_location" name="event_location" type="text" maxlength="150"
                                    value="{{ old('event_location') }}">
                                @error('event_location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_time">Event Time</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <input class="form-control @error('event_time') is-invalid @enderror"
                                            id="event_time" name="event_time" type="time">
                                        @error('event_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="logo_file">Logo File</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('logo_file') is-invalid @enderror" id="logo_file"
                                    name="logo_file" type="file" accept="image/jpeg,image/png,image/jpg">
                                @error('logo_file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="intro_file">Intro File</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('intro_file') is-invalid @enderror" id="intro_file"
                                    name="intro_file" type="file" accept="image/jpeg,image/png,image/jpg">
                                @error('intro_file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="ticket_file">Ticket File</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('ticket_file') is-invalid @enderror" id="ticket_file"
                                    name="ticket_file" type="file" accept="image/jpeg,image/png,image/jpg">
                                @error('ticket_file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_description">Event Description</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <textarea class="form-control @error('event_description') is-invalid @enderror" id="event_description"
                                    name="event_description" rows="4">{{ old('event_description') }}</textarea>
                                @error('event_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_active">Active</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-check-input" id="event_active" name="event_active" type="checkbox"
                                    value="1" {{ old('event_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="event_active">Is Active</label>
                                @error('event_active')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>



                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-3">
                                <label class="form-label fw-bold" for="event_max_pax">Max Pax</label>
                            </div>
                            <div class="col-12 col-lg-9">
                                <input class="form-control @error('event_max_pax') is-invalid @enderror"
                                    id="event_max_pax" name="event_max_pax" type="number" min="1"
                                    value="{{ old('event_max_pax') }}">
                                @error('event_max_pax')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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
    <script type="module">
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat'
        });
    </script>
    {{-- <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            // Get start and end time values
            const startTime = document.getElementById('event_start_time').value;
            const endTime = document.getElementById('event_end_time').value;

            // Combine start and end times into a single string
            const eventTime = `${startTime} - ${endTime}`;

            // Set the combined string to the hidden input
            document.getElementById('event_time').value = eventTime;
            console.log('Event Time:', eventTime);
        });
    </script> --}}

    <script>
        function setMinEndDate() {
            const startDate = document.getElementById('event_start_date').value;
            const endDateInput = document.getElementById('event_end_date');

            if (startDate) {
                // Enable the end date input once a start date is selected
                endDateInput.disabled = false;

                // Set the minimum value of end date to the selected start date
                endDateInput.min = startDate;
            } else {
                // Disable the end date input if no start date is selected
                endDateInput.disabled = true;
                endDateInput.value = ''; // Clear the end date if start date is cleared
            }
        }
    </script>

    {{-- Masked Text --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formMasked = document.querySelectorAll('form input[data-masked]')
            formMasked.forEach(el => {
                switch (el.dataset.masked) {
                    case "number":
                        const masked = IMask(el, {
                            mask: Number,
                            min: parseInt(el.dataset.maskedMin),
                            radix: '.',
                            mapToRadix: [','],
                        })

                        if (el.dataset.maskedMax) {
                            masked.updateOptions({
                                max: parseInt(el.dataset.maskedMax)
                            })
                        }
                        break;

                    default:
                        break;
                }
            })
        })
    </script>
@endpush
