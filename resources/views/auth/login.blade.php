@extends('layouts.auth')

@section('content')
    <div class="d-flex flex-column flex-root min-vh-100">
        <div class="page d-flex flex-row flex-column-fluid">
            <main class="page-content overflow-hidden ms-0 d-flex flex-column flex-row-fluid">
                <div class="content p-1 d-flex flex-column-fluid position-relative">
                    <div class="container d-flex align-items-center justify-content-center py-4">
                        <div class="row w-100 justify-content-center">
                            <div class="col-md-8 col-lg-5 col-xl-4">
                                <a href="."
                                    class="d-flex position-relative mb-4 z-index-1 align-items-center justify-content-center">
                                    <!-- Logo or other content can go here -->
                                </a>
                                <!-- Card -->
                                <div class="card card-body bg-transparent p-4">
                                    <h4 class="text-center mb-4">Login Admin Event</h4>
                                    <form action="{{ route('login') }}" class="z-index-1 position-relative needs-validation"
                                        novalidate="" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" name="user_name"
                                                class="form-control @error('username') is-invalid @enderror" required=""
                                                id="floatingInput" placeholder="Enter your username" />
                                            <label for="floatingInput">Username</label>
                                            @error('username')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" name="user_password" required=""
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="floatingPassword" placeholder="Password" />
                                            <label for="floatingPassword">Password</label>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input me-1" id="terms" type="checkbox"
                                                    name="remember_me" value="" />
                                                <label class="form-check-label" for="terms">Remember Me</label>
                                            </div>
                                        </div>
                                        <button class="w-100 btn btn-lg btn-dark" type="submit">
                                            Sign In
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <footer class="pb-4">
                    <div class="container-fluid px-4">
                        <span class="d-block lh-sm small text-muted text-end">&copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            . Copyright
                        </span>
                    </div>
                </footer>
            </main>
        </div>
    </div>
@endsection
