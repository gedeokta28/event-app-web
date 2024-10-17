<aside class="page-sidebar">
    <div class="h-100 flex-column d-flex" data-simplebar>

        <!--Aside-logo-->
        <div class="aside-logo p-3 position-relative">
            <a href="index.html" class="d-block pe-2">
                <div class="d-flex align-items-center flex-no-wrap text-truncate">
                    <!--Sidebar-icon-->
                    {{-- <img src="{{ asset('assets/images/event.png') }}" alt="logo" width="60" height="60"> --}}
                    <span class="sidebar-text">
                        <!--Sidebar-text-->
                        <span class="sidebar-text text-truncate fs-4 text-uppercase fw-bolder">
                            BEYOND LIVING
                        </span>
                    </span>
                </div>
            </a>
        </div>
        <!--Aside-Menu-->
        <div class="aside-menu pe-2 my-auto flex-column-fluid">
            <nav class="flex-grow-1 h-100" id="page-navbar">
                <!--:Sidebar nav-->
                <ul class="nav flex-column collapse-group collapse d-flex pt-4">
                    <li class="nav-item mt-2 sidebar-title text-truncate small opacity-50">
                        <i class="fas fa-ellipsis-h align-middle"></i>
                        <span>Main</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('dashboard')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M12.97 2.59a1.5 1.5 0 00-1.94 0l-7.5 6.363A1.5 1.5 0 003 10.097V19.5A1.5 1.5 0 004.5 21h4.75a.75.75 0 00.75-.75V14h4v6.25c0 .414.336.75.75.75h4.75a1.5 1.5 0 001.5-1.5v-9.403a1.5 1.5 0 00-.53-1.144l-7.5-6.363z">
                                    </path>
                                </svg>
                            </span>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('attendance') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('attendance')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <i class="fas fa-camera" style="font-size: 20px; width: 20px; height: 20px;"></i>
                            </span>
                            <span class="sidebar-text">Scan Via Camera</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('attendance-tools') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('attendance-tools')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <i class="fas fa-desktop" style="font-size: 20px; width: 20px; height: 20px;"></i>
                            </span>
                            <span class="sidebar-text">Scan Via Tools </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('attendance.form') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('attendance.form')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" width="24" height="24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 10h1M7 16h1M7 14h1M7 12h1M7 8h1" />
                                </svg>
                            </span>
                            <span class="sidebar-text">Count Attendance</span>
                        </a>
                    </li>

                    <li class="nav-item mt-2 sidebar-title text-truncate small opacity-50">
                        <i class="fas fa-ellipsis-h align-middle"></i>
                        <span>Management</span>
                    </li>

                    @superadmin(auth()->user())
                        <li class="nav-item">
                            <a href="#events" data-bs-toggle="collapse" aria-expanded="false"
                                class="nav-link d-flex align-items-center text-truncate @if (Route::is('events.*')) active @endif">
                                <span class="sidebar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>

                                </span>
                                <!--Sidebar nav text-->
                                <span class="sidebar-text">Events</span>
                            </a>
                            <ul id="events" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('events.index') }}">List</a>
                                </li>
                                <li class="sidebar-item"><a class="sidebar-link"
                                        href="{{ route('events.create') }}">Create</a>
                                </li>
                            </ul>
                        </li>
                    @endsuperadmin

                    <li class="nav-item">
                        <a href="#registration" data-bs-toggle="collapse" aria-expanded="false"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('registration.*')) active @endif">
                            <span class="sidebar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>

                            </span>
                            <!--Sidebar nav text-->
                            <span class="sidebar-text">Registrations</span>
                        </a>
                        <ul id="registration" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="{{ route('registration.index') }}">List</a>
                            </li>

                        </ul>
                    </li>
                    @superadmin(auth()->user())
                        <li class="nav-item">
                            <a href="#users" data-bs-toggle="collapse" aria-expanded="false"
                                class="nav-link d-flex align-items-center text-truncate @if (Route::is('users.*')) active @endif">
                                <span class="sidebar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>

                                </span>
                                <!--Sidebar nav text-->
                                <span class="sidebar-text">User Admin Event</span>
                            </a>
                            <ul id="users" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item"><a class="sidebar-link"
                                        href="{{ route('users.index') }}">List</a>
                                </li>
                                <li class="sidebar-item"><a class="sidebar-link"
                                        href="{{ route('users.create') }}">Create</a>
                                </li>
                            </ul>
                        </li>
                    @endsuperadmin

                    <li class="nav-item mt-2 sidebar-title text-truncate small opacity-50">
                        <i class="fas fa-ellipsis-h align-middle"></i>
                        <span>Report</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('report-attendance') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('report-attendance')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <i class="fas fa-user-check" style="font-size: 17px; width: 17px; height: 17px;"></i>
                                <!-- Icon for Attendance -->
                            </span>
                            <span class="sidebar-text">Attendance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('report-registration') }}"
                            class="nav-link d-flex align-items-center text-truncate @if (Route::is('report-registration')) active @endif"
                            aria-expanded="false">
                            <span class="sidebar-icon">
                                <i class="fas fa-clipboard-list"
                                    style="font-size: 17px; width: 17px; height: 17px;"></i>
                                <!-- Icon for Registration -->
                            </span>
                            <span class="sidebar-text">Registration</span>
                        </a>
                    </li>
                    {{-- @superadmin(auth()->user())
                        <li class="nav-item">
                            <a href="#variantOption"
                               data-bs-toggle="collapse"
                               aria-expanded="false"
                               class="nav-link d-flex align-items-center text-truncate @if (Route::is('variant-options.*')) active @endif">
                                <span class="sidebar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-versions"
                                         width="24"
                                         height="24"
                                         viewBox="0 0 24 24"
                                         stroke-width="2"
                                         stroke="currentColor"
                                         fill="none"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path stroke="none"
                                              d="M0 0h24v24H0z"
                                              fill="none"></path>
                                        <path
                                              d="M10 5m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                                        </path>
                                        <path d="M7 7l0 10"></path>
                                        <path d="M4 8l0 8"></path>
                                    </svg>
                                </span>
                                <!--Sidebar nav text-->
                                <span class="sidebar-text">Variant Option</span>
                            </a>
                            <ul id="variantOption"
                                class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item"><a class="sidebar-link"
                                       href="{{ route('variant-options.index') }}">List</a>
                                </li>
                                <li class="sidebar-item"><a class="sidebar-link"
                                       href="{{ route('variant-options.create') }}">Create</a>
                                </li>
                            </ul>
                        </li>
                    @endsuperadmin --}}


                </ul>
            </nav>
        </div>
    </div>
</aside>

<div class="sidebar-close d-lg-none">
    <a href="#"></a>
</div>
