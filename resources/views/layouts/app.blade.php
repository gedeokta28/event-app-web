<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Event App') }}</title>

    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" id="switchThemeStyle">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/scss/datatable.scss') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/scss/toastify.scss') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome5-free/css/all.min.css') }}">

    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('head')
</head>

<body>
    <div class="loader">
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">

                <!--Sidebar start-->
                <aside class="page-sidebar aside-dark placeholder-wave">
                    <div class="placeholder col-12 h-100 bg-gray"></div>
                </aside>
                <div class="page-content d-flex flex-column flex-row-fluid">
                    <div
                        class="content flex-column p-4 pb-0 d-flex justify-content-center align-items-center flex-column-fluid position-relative">
                        <div class="w-100 h-100 position-relative d-flex align-items-center justify-content-center">
                            <i class="anim-spinner fas fa-spinner me-3"></i>
                            <div>
                                <span>Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-root">
        <!--Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            @include('layouts._sidebar')

            <main class="page-content d-flex flex-column flex-row-fluid">

                @include('layouts._header')

                <!--//Chat offcanvas start//-->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasChat"
                    aria-labelledby="offcanvasChatLabel">

                    <!--Chat header-->
                    <div
                        class="offcanvas-header height-70 d-flex align-items-center justify-content-between border-bottom shadow-none">
                        <div>
                            <h5 class="offcanvas-title mb-0 lh-1" id="offcanvasChatLabel">Adam Voges</h5>
                            <div class="d-flex align-items-center">
                                <span
                                    class="size-5 border border-3 rounded-circle border-success me-2 d-block"></span>Online
                            </div>
                        </div>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <!--Chat body-->
                    <div class="offcanvas-body p-0 flex-row-fluid">
                        <div class="d-flex p-3 flex-column-reverse h-100" style="overflow-y: auto;">
                            <div class="flex-shrink-0 w-100">

                                <!--Alert-->
                                <div class="alert border-0 shadow bg-gradient-primary text-white p-5 mb-4">
                                    <h5>Get more access with our paid plans</h5>
                                    <p class="text-truncate">
                                        Duis aute irure
                                        dolor in voluptate velit esse cillum
                                        dolore eu
                                        fugiat nulla pariatur.
                                    </p>
                                    <a href="#!" class="btn btn-white">See upgrade
                                        options</a>
                                </div>
                                <!--Chat divider with day/month-->
                                <div class="d-flex mb-4 align-items-center justify-content-center">
                                    <div class="text-muted small">
                                        Today, 12:10PM</div>
                                </div>

                                <!--User chat box-->
                                <div class="c_message_in c_message_box mb-4">

                                    <!--chat message avatar-->
                                    <div class="c_message_avatar">
                                        <img src="assets/media/avatars/03.jpg" class="" alt="">
                                    </div>

                                    <div class="flex-grow-1">
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="12:10PM">
                                            <span class="c_message-text">Hi
                                                Adam</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="12:10PM">
                                            <span class="c_message-text">I
                                                checked your admin theme, It
                                                looks awesome! I want to
                                                customize few layouts, Are you
                                                available for
                                                customization</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="12:10PM">
                                            <span class="c_message-text">If
                                                Yes, Please share your
                                                skype, So we go through
                                                details</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--Chat messages self-->
                                <div class="c_message_out c_message_box mb-4">

                                    <!--chat message avatar-->
                                    <div class="c_message_avatar">
                                        <img src="assets/media/avatars/01.jpg" class="" alt="">
                                    </div>
                                    <div class="flex-grow-1">
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="right" title="12:10PM">
                                            <span class="c_message-text">Hi
                                                Adam</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="right" title="12:33PM">
                                            <span class="c_message-text">I
                                                would love to work with
                                                you</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="right" title="12:33PM">
                                            <span class="c_message-text">Here
                                                is the demo of link with
                                                chat
                                                <span class="d-block pt-2">
                                                    <a href="#!" class="c_message_link">skype.123</a>
                                                </span>
                                            </span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!--User chat box-->
                                <div class="c_message_in c_message_box mb-4">

                                    <!--chat message avatar-->
                                    <div class="c_message_avatar">
                                        <img src="assets/media/avatars/03.jpg" class="" alt="">
                                    </div>

                                    <div class="flex-grow-1">
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="13:02PM">
                                            <span class="c_message-text">Thanks
                                                for your response</span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--chat-message-and-action-->
                                        <div class="c_message_content d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="13:04PM">
                                            <span class="c_message-text">Here
                                                are some images files for
                                                chat demo
                                                <span class="d-flex py-2 flex-wrap">
                                                    <!--File-->
                                                    <a href="#!"
                                                        class="card-hover me-2 position-relative width-90">
                                                        <span
                                                            class="hover-image mb-1 position-relative d-block overflow-hidden rounded-3">
                                                            <img src="assets/media/900x600/2.jpg" class="img-fluid"
                                                                alt="">
                                                            <span
                                                                class="hover-image-overlay position-absolute start-0 top-0 w-100 h-100 d-flex justify-content-center align-items-center text-white">
                                                                <span>
                                                                    <i class="fas fa-download small ms-1"></i>
                                                                </span>
                                                            </span>
                                                        </span>

                                                        <!--File description-->
                                                        <span class="d-block text-body text-truncate">
                                                            photo-9304157018321
                                                        </span>
                                                        <span class="d-block text-muted text-truncate">
                                                            257KB
                                                        </span>
                                                    </a>
                                                    <!--File-->
                                                    <a href="#!" class="card-hover position-relative width-90">
                                                        <span
                                                            class="hover-image position-relative d-block mb-1 overflow-hidden rounded-3">
                                                            <img src="assets/media/900x600/4.jpg" class="img-fluid"
                                                                alt="">
                                                            <span
                                                                class="hover-image-overlay position-absolute start-0 top-0 w-100 h-100 d-flex justify-content-center align-items-center text-white">
                                                                <span>
                                                                    <i class="fas fa-download small ms-1"></i>
                                                                </span>
                                                            </span>
                                                        </span>

                                                        <!--File description-->
                                                        <span class="d-block text-body text-truncate">
                                                            photo-1633113088983
                                                        </span>
                                                        <span class="d-block text-muted text-truncate">
                                                            300KB
                                                        </span>
                                                    </a>
                                                </span>
                                            </span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--chat-message-and-action-->
                                        <div class="c_message_content c_message-typing d-flex align-items-center">
                                            <span class="c_message-text">
                                                <span class="typing">
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                </span>
                                            </span>

                                            <!--Actions-->
                                            <div class="c_message_actions d-flex align-items-center">
                                                <a href="#!" class="c_action">
                                                    <i class="far fa-smile small"></i>
                                                </a>
                                                <a href="#!" class="c_action">
                                                    <i class="fas fa-reply small"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <a href="#" class="c_action" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v small"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <a href="#!" class="dropdown-item">
                                                            Remove
                                                        </a>
                                                        <a href="#!" class="dropdown-item">
                                                            Forward
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Chat footer-->
                    <div class="offcanvas-footer mt-auto p-2 border-top shadow position-relative">
                        <div class="position-relative p-4">
                            <form>
                                <input type="text" placeholder="Type here..."
                                    class="form-control bg-transparent ps-2 pe-5 border-0 shadow-none rounded-0 position-absolute w-100 h-100 start-0 top-0">
                                <button type="submit"
                                    class="btn p-0 btn-primary rounded-pill d-flex align-items-center justify-content-center size-35 position-absolute end-0 top-50 translate-middle-y">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!--//Page Toolbar//-->
                @yield('toolbar')
                <!--//Page Toolbar End//-->

                <!--//Page content//-->
                @yield('content')
                <!--//Page content End//-->

            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ Vite::asset('resources/js/app.js') }}" type="module"></script>
    <script src="{{ asset('assets/js/theme.bundle.js') }}"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/toastify.js') }}" type="module"></script>

    <script src="{{ Vite::asset('resources/js/datatable.js') }}" type="module"></script>
    @stack('scripts')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session()->has('success'))
        <script type="module">
            setTimeout(() => {
                Swal.fire("Sukses", "{{ session()->get('success') }}", "success");
            }, 700);
        </script>
    @endif
</body>

</html>
