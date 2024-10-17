<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        #intro {
            width: 100%;
            height: 100vh;
            background: url('{{ asset('app/' . $event->intro_file) }}') top center;
            background-size: cover;
            overflow: hidden;
            position: relative;
        }

        .register-btn {
            color: #fff;
            background: #f82249;
            font-family: "Raleway", sans-serif;
            font-size: 15px;
            letter-spacing: 1px;
            padding: 10px 25px;
            border-radius: 50px;
            border: 2px solid #f82249;
            transition: all ease-in-out 0.3s;
            font-weight: 600;
            margin-left: 0px;
            margin-top: 2px;
            line-height: 1;
            text-transform: uppercase;
        }

        .register-btn:hover {
            background: transparent;
            color: #f82249;
            /* Warna border muncul sebagai warna teks saat hover */
        }

        #venue .venue-info {
            background: url('{{ asset('assets/event/img/venue-info-bg.jpg') }}') top center no-repeat;
            background-size: cover;
            position: relative;
            padding-top: 60px;
            padding-bottom: 60px;
        }

        #about {
            background: url('{{ asset('assets/event/img/about-bg.jpg') }}');
            background-size: cover;
            overflow: hidden;
            position: relative;
            color: #fff;
            padding: 60px 0 40px 0;
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



        #subscribe {
            padding: 60px;
            background: url(../img/subscribe-bg.jpg) center center no-repeat;
            background-size: cover;
            overflow: hidden;
            position: relative;
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

    <!--==========================
    Header
  ============================-->
    <header id="header" class="header-fixed">
        <div class="container">

            <div id="logo" class="pull-left">
                <!-- Uncomment below if you prefer to use a text logo -->
                <!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
                <a href="#intro" class="scrollto"><img src="{{ asset('assets/images/event.png') }}" alt=""
                        title=""></a>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class=""><a href="{{ route('guests.index') }}">Home</a>
                    </li>
                    <li><a href="{{ route('guests.index') }}#speakers">Event Listings</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->



    <main id="main" class="main-page">

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
        <!--==========================
      Speaker Details Section
    ============================-->
        <section id="speakers-details" class="wow fadeIn">
            <div class="container">
                <div class="section-header">
                    <h2>{{ $event->event_name }}</h2>
                    <p> <i class="fa fa-map-marker"></i> {{ $event->event_location ?? 'Event Location' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('app/' . $event->intro_file) }}" alt="Speaker 1" class="img-fluid">
                    </div>

                    <div class="col-md-6">
                        <div class="details">
                            @if (!empty($event->logo_file))
                                <img src="{{ asset('app/' . $event->logo_file) }}" alt="Event Logo"
                                    class="event-logo-listing mb-3">
                            @else
                            @endif
                            <h5>{{ $formattedDateRange ?? '' }} At {{ $eventTime->format('h:i A') ?? '' }}</h5>
                            {!! $event->event_description ?? 'Event Description' !!}
                            <button type="button" class="btn" data-toggle="modal"
                                data-target="#buy-ticket-modal">Register
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
                                    <input type="text" class="form-control" name="pax_name" placeholder="Your Name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pax_phone"
                                        placeholder="Your Phone Number (Ex: 081234567981)" pattern="[0-9]+"
                                        title="Please enter only numbers" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="pax_email" placeholder="Your Email"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pax_company_name"
                                        placeholder="Your Company Name" required>
                                </div>
                                <div class="form-group">
                                    <p class="text-muted">Please ensure your phone number is connected to WhatsApp, as
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

        </section>

    </main>


    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

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
