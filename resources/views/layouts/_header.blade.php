<header class="navbar py-0 page-header border-bottom navbar-expand navbar-light px-4">
    <a href="{{ route('dashboard') }}" class="navbar-brand d-block d-lg-none">
        <div class="d-flex align-items-center flex-no-wrap text-truncate">
            <!--Sidebar-icon-->
            <span
                class="sidebar-icon bg-dark rounded-circle size-40 text-white d-flex align-items-center justify-content-center">
                B
            </span>
        </div>

    </a>
    <ul class="navbar-nav d-flex align-items-center h-100">
        <li class="nav-item d-none d-lg-flex flex-column h-100 me-lg-2 align-items-center justify-content-center">
            <a href="javascript:void(0)"
                class="sidebar-trigger nav-link rounded-3 size-35 d-flex align-items-center justify-content-center p-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" width="16"
                    height="16">
                    <path fill-rule="evenodd"
                        d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z">
                    </path>
                </svg>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto d-flex align-items-center h-100">
        <li class="nav-item dropdown d-flex align-items-center justify-content-center flex-column h-100">
            <a href="#"
                class="nav-link dropdown-toggle rounded-pill p-1 lh-1 pe-1 pe-md-2 d-flex align-items-center justify-content-center"
                aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <div class="d-flex align-items-center">
                    <div class="avatar-status status-online me-1 avatar sm">
                        <img src="{{ auth()->user()?->getPhotoProfile() }}" class="rounded-circle img-fluid"
                            alt="">
                    </div>
                </div>
            </a>

            <div class="dropdown-menu mt-0 p-0 dropdown-menu-end overflow-hidden">
                <!--User meta-->
                <div class="position-relative overflow-hidden p-4 bg-gradient-dark text-white">
                    <div class="position-relative">
                        <h5 class="mb-1">{{ auth()->user()?->user_name }}</h5>
                        <p class="text-muted small mb-0 lh-1 text-capitalize">
                            {{ auth()->user()?->user_role }}</p>
                    </div>
                </div>
                <div class="p-2">
                    {{-- <a href="{{ route('profile.index') }}" class="dropdown-item">
                        <i class="fas fa-user opacity-50 align-middle me-2"></i>Profile</a> --}}
                    {{-- <hr class="mt-3 mb-1"> --}}
                    <form action="{{ route('logout') }}" method="post" id="logoutform">
                        @csrf
                        <a href="#" onclick="document.getElementById('logoutform')?.submit();"
                            class="dropdown-item d-flex align-items-center">
                            <i class="fas fa-sign-out-alt opacity-50 align-middle me-2"></i>
                            Sign out
                        </a>
                    </form>
                </div>
            </div>
        </li>
        <li
            class="nav-item dropdown ms-1 ms-lg-3 d-flex d-lg-none align-items-center justify-content-center flex-column h-100">
            <a href="#"
                class="nav-link sidebar-trigger-lg-down size-35 p-0 d-flex align-items-center justify-content-center rounded-3">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
</header>
