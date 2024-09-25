@extends('layouts.app')
<style>
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        min-width: 250px;
        max-width: 300px;
        background-color: #333;
        color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: opacity 0.5s ease;
        z-index: 1000;
    }

    .toast.show {
        opacity: 1;
    }
</style>
@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/dashboard" class="">Home</a></li>
                            <li class="breadcrumb-item active">
                                Scan Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- <div id="customAlert"
        style="display: none; position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 10px; border-radius: 5px;">
        <span id="alertMessage"></span>
    </div> --}}

    <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="card">
                    <div class="card-header w-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>Scan Barcode Ticket</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" id="customAlert"
                            style="display: none; background: #4CAF50; color: white;">
                            <span id="alertMessage"></span>
                        </div>
                        <form id="scanForm">
                            <label for="barcodeInput">Scan your barcode here:</label><br />
                            <input type="text" id="barcodeInput" name="event_ticket_no"
                                onkeypress="handleBarcodeInput(event)" autofocus />
                        </form>
                        <!-- Modal -->
                        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog"
                            aria-labelledby="alertModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="alertModalLabel">Pesan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage">
                                        <!-- Pesan akan ditampilkan di sini -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function handleBarcodeInput(event) {
            if (event.key === 'Enter') {
                // Ketika Enter ditekan (biasanya scanner mengirim Enter di akhir input)
                let barcodeValue = event.target.value; // Ambil nilai dari textbox
                alert('Barcode Scanned: ' + barcodeValue);

                // Lakukan aksi yang Anda butuhkan di sini
                // Misalnya, kirim data barcode ke backend melalui AJAX atau redirect
                // event.target.value = ''; // Kosongkan input jika perlu
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            // Fokuskan otomatis ke textbox agar siap untuk input
            document.getElementById('barcodeInput').focus();
        });
    </script>
    <script>
        function handleBarcodeInput(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                // Ambil nilai dari textbox
                let barcodeValue = event.target.value;

                // Kirim data ke backend melalui AJAX
                $.ajax({
                    url: '{{ route('attendance.scan') }}', // Ganti dengan rute yang sesuai
                    method: 'POST',
                    data: {
                        event_ticket_no: barcodeValue,
                        _token: '{{ csrf_token() }}' // Sertakan token CSRF untuk keamanan
                    },
                    success: function(response) {
                        // alert(response.message);
                        // event.target.value = '';
                        // setTimeout(function() {

                        // }, 2000);
                        $('#alertMessage').text(response.message);
                        $('#customAlert').fadeIn();
                        event.target.value = '';

                        setTimeout(function() {
                            $('#customAlert').fadeOut();
                        }, 2000);
                    },

                    error: function(xhr) {
                        event.target.value = '';
                        alert(xhr.responseJSON.message || 'Terjadi kesalahan.');
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            // Fokuskan otomatis ke textbox agar siap untuk input
            document.getElementById('barcodeInput').focus();
        });
    </script>
@endpush
