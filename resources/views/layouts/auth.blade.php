<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Css -->
    <link rel="stylesheet"
          href="{{ asset('assets/css/style.min.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch"
          href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito"
          rel="stylesheet">
    <link rel="stylesheet"
          href="{{ asset('assets/fonts/font-awesome5-free/css/all.min.css') }}">
</head>

<body>
    <div class="loader">
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <div
                     class="page-content ps-0 ms-0 d-flex flex-column flex-row-fluid">
                    <div
                         class="content flex-column p-4 pb-0 d-flex justify-content-center align-items-center flex-column-fluid position-relative">
                        <div
                             class="w-100 h-100 position-relative d-flex align-items-center justify-content-center">
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

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/theme.bundle.js') }}"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>
</body>

</html>
