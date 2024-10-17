@extends('layouts.app')
<style>
    #scanner-container {
        position: relative;
        width: 100%;
        /* Menggunakan 100% dari lebar layar */
        height: 50vh;
        /* Menggunakan 50% dari tinggi viewport */
        overflow: hidden;
        /* Background hitam untuk kontras */
    }

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

    #loading {
        display: none;
        /* Sembunyikan secara default */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.8);
        /* Latar belakang transparan */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 10;
        /* Pastikan di atas elemen lain */
    }

    #loading p {
        margin: 0;
        font-size: 18px;
        /* Ukuran font */
        color: #333;
        /* Warna teks */
    }

    /* #overlay {
        position: absolute;
        top: 20%;
        left: 10%;
        width: 80%;
        height: 60%;
        border: 2px dashed red;
        pointer-events: none;
        background-color: rgba(255, 0, 0, 0.2);
    } */

    /* Media Query untuk perangkat lebih kecil */
    @media (max-width: 768px) {
        #scanner-container {
            height: 60vh;
            /* Menambah tinggi untuk perangkat kecil */
        }

        #overlay {
            top: 15%;
            /* Atur posisi atas kotak tanda */
            left: 5%;
            /* Atur posisi kiri kotak tanda */
            width: 90%;
            /* Lebar kotak tanda */
            height: 70%;
            /* Tinggi kotak tanda */
        }
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
                                Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div id="toast" class="toast"></div>
    <div class="container">
        <h2>Scan Barcode Ticket</h2>
        <div id="scanner-container" style="position: relative;">
            <div id="overlay"
                style="position: absolute; border: 2px dashed red; pointer-events: none; background-color: rgba(255, 0, 0, 0.2);">
            </div>
            <div id="loading"
                style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <p>Loading...</p>
            </div>
        </div>
        <div id="barcode-result"></div>
    </div>
@endsection

@push('scripts')
    <script>
        function showToast(message, isSuccess) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336'; // Green for success, red for error
            toast.classList.add('show');

            // Hide the toast after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }


        document.addEventListener("DOMContentLoaded", function() {
            const scannerContainer = document.querySelector('#scanner-container');
            const overlay = document.querySelector('#overlay');
            const loadingIndicator = document.getElementById('loading');
            // Sesuaikan ukuran overlay saat halaman dimuat
            function setOverlaySize() {
                overlay.style.width = `${scannerContainer.clientWidth * 0.8}px`;
                overlay.style.height = `${scannerContainer.clientHeight * 0.6}px`;
                overlay.style.top = `${scannerContainer.clientHeight * 0.2}px`;
                overlay.style.left = `${scannerContainer.clientWidth * 0.1}px`;
            }

            setOverlaySize();
            window.addEventListener('resize', setOverlaySize);

            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: scannerContainer,
                },
                decoder: {
                    readers: ["code_128_reader"]
                },
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                console.log("QuaggaJS ready to start");
                Quagga.start();
            });


            Quagga.onDetected(function(data) {
                let barcode = data.codeResult.code;
                console.log("Barcode detected: " + barcode);
                document.getElementById('barcode-result').innerHTML = "Barcode Detected: " + barcode;
                Quagga.stop();
                // Tampilkan loading indicator
                loadingIndicator.style.display = 'block';

                function showToast(message, isSuccess) {
                    const toast = document.getElementById('toast');
                    toast.textContent = message;
                    toast.style.backgroundColor = isSuccess ? '#4CAF50' :
                        '#f44336'; // Green for success, red for error
                    toast.classList.add('show');

                    // Hide the toast after 3 seconds
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);
                }
                fetch("{{ route('attendance.scan') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            event_ticket_no: barcode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        loadingIndicator.style.display = 'none';


                        if (data.success) {
                            showToast(data.message, true); // Show success toast
                            // Redirect after a short delay
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('attendance') }}"; // Adjust to your redirect route
                            }, 2000); // Wait for toast to finish before redirecting
                        } else {
                            showToast('Error: ' + data.message, false); // Show error toast
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('attendance') }}"; // Adjust to your redirect route
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        loadingIndicator.style.display = 'none';
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan, silakan coba lagi.', false); // Show error toast
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('attendance') }}"; // Adjust to your redirect route
                        }, 2000);
                    });
            });
        });
    </script>
@endpush
