<!DOCTYPE html>
<html lang="en">

<head>
    <meta property="og:title" content="{{ $event->event_name }}" />
    <meta property="og:description" content="{{ strip_tags($event->event_description) }}" />
    <meta property="og:image" content="{{ asset('app/' . $event->logo_file) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $event->event_name }}" />
    <meta name="twitter:description" content="{{ strip_tags($event->event_description) }}" />
    <meta name="twitter:image" content="{{ asset('app/' . $event->logo_file) }}" />
    <style>
        .form-control {
            font-size: 12p;
            /* Adjust the size as needed */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body {
            font-family: "Open Sans", sans-serif;
            overflow: hidden;
            /* Mencegah scroll di body */
            position: relative;
            /* Membuat posisi relatif untuk overlay */
        }

        .background {
            position: fixed;
            /* Memastikan latar belakang tetap di tempat */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('app/' . $event->intro_file) }}') top center;
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1;
            /* Di belakang konten */
        }

        body::before {
            content: '';
            position: fixed;
            /* Overlay tetap di tempat */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.78);
            /* Overlay hitam */
            z-index: 0;
            /* Di atas gambar latar belakang tetapi di bawah konten */
        }


        .content {
            position: relative;
            z-index: 1;
            /* Di atas overlay */
            color: white;
            /* Warna teks agar terlihat di atas overlay */
            padding: 30px;
            /* Sesuaikan padding jika perlu */
            height: 100vh;
            /* Mengatur tinggi konten sesuai layar */
            overflow-y: auto;
            justify-content: center;
            /* Scroll konten di dalam */
        }

        #buy-ticket-modal input,
        #buy-ticket-modal select {
            border-radius: 0;
        }

        #buy-ticket-modal .btn {
            border-radius: 50px;
            padding: 10px 40px;
            transition: all 0.2s;
            background-color: #f82249;
            border: 0;
            color: #fff;
        }

        #buy-ticket-modal .btn:hover {
            background-color: #e0072f;
        }

        .event-logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .event-logo-listing {
            width: 35px;
            height: auto;
        }
    </style>
    <meta charset="utf-8">
    <title>{{ $event->event_name }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="img/favicon.png') }}" rel="icon">
    <link href="img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800"
        rel="stylesheet">

    <!-- Bootstrap CSS File -->

    <link href="{{ asset('assets/event/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{ asset('assets/event/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/event/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/event/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/event/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Main Stylesheet File -->
    <link href="{{ asset('assets/event/style.css') }}" rel="stylesheet">


    <!-- =======================================================
    Theme Name: TheEvent
    Theme URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>
    <div class="background"></div>
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('app/' . $event->logo_file) }}" alt="Speaker 1" class="img-fluid">
            </div>

            <div class="col-md-6">
                <div class="details">
                    <h2>{{ $event->event_name }}</h2>
                    <p> <i class="fa fa-map-marker"></i> {{ $event->event_location ?? 'Event Location' }}</p>
                    {!! $event->event_description ?? 'Event Description' !!}
                    <button type="button" class="btn" data-toggle="modal" data-target="#buy-ticket-modal">Register
                        Now</button>

                </div>
            </div>

        </div>


    </div>

    <div id="buy-ticket-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registration-form" method="POST" action="{{ route('events.register') }}">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                        <div class="form-group">
                            <label for="age_group">Name</label>
                            <input type="text" class="form-control" name="pax_name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="age_group">Whatsapp Number</label>
                            <input type="text" class="form-control" name="pax_phone"
                                placeholder="Your Phone Number (Ex: 081234567981)" pattern="[0-9]+"
                                title="Please enter only numbers" required>
                        </div>
                        <div class="form-group">
                            <label for="age_group">Email</label>
                            <input type="email" class="form-control" name="pax_email" placeholder="Your Email"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="age_group">Age</label>
                            <select class="form-control" name="pax_age" required>
                                <option value="" selected disabled>Age</option>
                                <option value="20-30">20 - 30</option>
                                <option value="31-40">31 - 40</option>
                                <option value="41-50">41 - 50</option>
                                <option value="51-60+">51 - 60+</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="purpose_of_visit">Purpose of Visit</label>
                            <select class="form-control" id="purpose_of_visit" name="pax_purpose_of_visit" required>
                                <option value="" selected disabled>Purpose of Visit</option>
                                <option value="Inspiration for Building Design">Inspiration for Building
                                    Design
                                </option>
                                <option value="Exploring Homeownership Options">Exploring Homeownership
                                    Options
                                </option>
                                <option value="For Leisure - R&R (Rest and Relaxation)">
                                    For Leisure - R&R (Rest and Relaxation)
                                </option>
                                <option value="Other" data-require="true">Other</option>
                            </select>
                        </div>

                        <div class="form-group" id="other_purpose_group" style="display: none;">
                            <label for="other_purpose">Please specify</label>
                            <textarea class="form-control" name="other_purpose" id="other_purpose" placeholder="Specify your purpose"></textarea>
                        </div>
                        <div class="form-group">
                            <p class="text-muted">*Please ensure your phone number is connected to
                                WhatsApp, as
                                tickets will be sent via WhatsApp.</p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn">Register</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script>
        // document.getElementById('purpose_of_visit').addEventListener('change', function() {
        //     var otherPurposeGroup = document.getElementById('other_purpose_group');
        //     if (this.value === 'Other') {
        //         otherPurposeGroup.style.display = 'block';
        //     } else {
        //         otherPurposeGroup.style.display = 'none';
        //     }
        // });
        document.addEventListener('DOMContentLoaded', function() {
            const purposeSelect = document.getElementById('purpose_of_visit');
            const otherPurposeGroup = document.getElementById('other_purpose_group');
            const otherPurposeInput = document.getElementById('other_purpose');
            const form = document.querySelector('form'); // Pastikan ini adalah form yang benar
            const ageSelect = document.getElementById('pax_age');

            // Menampilkan dan mewajibkan field 'other_purpose' jika opsi 'Other' dipilih
            purposeSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    otherPurposeGroup.style.display = 'block';
                    otherPurposeInput.setAttribute('required', 'required');
                } else {
                    otherPurposeGroup.style.display = 'none';
                    otherPurposeInput.removeAttribute('required');
                    otherPurposeInput.value = ''; // Kosongkan input jika tidak diperlukan
                }
            });

            // Validasi untuk opsi "Pilih Age" dan "Pilih Purpose of Visit"
            form.addEventListener('submit', function(event) {
                // Cek apakah pengguna sudah memilih Age
                if (!ageSelect.value) {
                    alert('Please select your Age.');
                    event.preventDefault();
                }

                // Cek apakah pengguna sudah memilih Purpose of Visit
                if (!purposeSelect.value) {
                    alert('Please select your Purpose of Visit.');
                    event.preventDefault();
                }
            });
        });
    </script>
    <script>
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            const phoneInput = document.querySelector('input[name="pax_phone"]');
            const phonePattern = /^[0-9]/; // Adjust the pattern as needed

            if (!phonePattern.test(phoneInput.value)) {
                alert('Please enter a valid phone number.');
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
    <!-- JavaScript Libraries -->
    <script src="{{ asset('assets/event/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/event/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/event/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/event/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/event/superfish/hoverIntent.js') }}"></script>
    <script src="{{ asset('assets/event/superfish/superfish.min.js') }}"></script>
    <script src="{{ asset('assets/event/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/event/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/event/owlcarousel/owl.carousel.min.js') }}"></script>


    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <link href="{{ asset('assets/event/animate/animate.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/event/js/main.js') }}"></script>
</body>

</html>
