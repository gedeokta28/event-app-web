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
            margin-left: 8px;
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
    <title>Events</title>
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
    <header id="header">
        <div class="container">

            <div id="logo" class="pull-left">
                <!-- Uncomment below if you prefer to use a text logo -->
                <!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
                <a href="#intro" class="scrollto"><img src="{{ asset('assets/images/event.png') }}" alt=""
                        title=""></a>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="#intro">Home</a></li>
                    <li><a href="#speakers">Event Listings</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

    <!--==========================
    Intro Section
  ============================-->
    <section id="intro">
        <div class="intro-container wow fadeIn">
            @if (!empty($event->logo_file))
                <img src="{{ asset('app/' . $event->logo_file) }}" alt="Event Logo" class="event-logo mb-4">
            @endif
            <h1 class="mb-4 pb-0">{{ $event->event_name ?? 'Event Name' }} </h1>
            <p class="mb-4 pb-0">{{ $formattedDateRange ?? 'Event Date Range' }}
                {{ $event->event_location ?? 'Event Location' }}
            </p>

            {{-- <a href="#about" class="about-btn scrollto">About The Event</a> --}}

            <!-- Registration Button -->
            <a href="{{ route('guests.event.detail', $event->event_id) }}" class="register-btn scrollto">Register
                Now</a>
        </div>
    </section>

    <main id="main">

        <!--==========================
      About Section
    ============================-->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>About The Event</h2>
                        {!! $event->event_description ?? 'Event Description' !!}
                    </div>
                    <div class="col-lg-3">
                        <h3>Where</h3>

                        <p> <i class="fa fa-map-marker"></i> {{ $event->event_location ?? 'Event Location' }}</p>
                    </div>
                    <div class="col-lg-3">
                        <h3>When</h3>
                        <p>
                            From {{ $formattedDayRange ?? '' }}<br>
                            {{ $formattedDateRange ?? '' }}<br>
                            At {{ $eventTime->format('h:i A') ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="speakers" class="wow fadeInUp">
            <div class="container">
                <div class="section-header">
                    <h2>Event Listing</h2>
                    <p>Here are some of our events</p>
                </div>
                @if ($eventList->isEmpty())
                    <p>No events available at the moment.</p>
                @else
                    <div class="row">
                        @foreach ($eventList as $eventObj)
                            <div class="col-lg-4 col-md-6">
                                <div class="speaker">
                                    <img src="{{ asset('app/' . $eventObj->intro_file) }}" alt="Speaker 1"
                                        class="img-fluid">
                                    <div class="details">
                                        @if (!empty($eventObj->logo_file))
                                            <img src="{{ asset('app/' . $eventObj->logo_file) }}" alt="Event Logo"
                                                class="event-logo-listing mb-3">
                                        @else
                                        @endif
                                        <h3><a
                                                href="{{ route('guests.event.detail', $eventObj->event_id) }}">{{ $eventObj->event_name }}</a>
                                        </h3>
                                        {!! $event->event_description ?? 'Event Description' !!}

                                    </div>
                                </div>
                            </div>
                        @endforeach
                @endif
            </div>
            </div>

        </section>

        {{-- <section id="speakers" class="wow fadeInUp">
            <div class="container">
                <div class="section-header">
                    <h2>Event Listing</h2>
                    <p>Here are some of our events</p>
                </div>

                <div class="row">
                    @if ($eventList->isEmpty())
                        <p>No events available at the moment.</p>
                    @else
                        @foreach ($eventList as $eventObj)
                            <div class="col-lg-4 col-md-6">
                                <div class="speakers">
                                    <!-- Display event logo if available -->
                                    @if (!empty($eventObj->logo_file))
                                        <img src="{{ asset('app/' . $eventObj->logo_file) }}"
                                            alt="{{ $eventObj->event_name }}" class="img-fluid">
                                    @else
                                        <img src="{{ asset('img/default-event.jpg') }}"
                                            alt="{{ $eventObj->event_name }}" class="img-fluid">
                                    @endif

                                    <div class="details">
                                        <h3><a href="">{{ $eventObj->event_name }}</a>
                                        </h3>
                                        <p>{{ $eventObj->formattedDateRange }} at {{ $eventObj->event_location }}</p>
                                        <p>{{ $eventObj->formattedDayRange }}</p>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section> --}}






    </main>


    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

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
