<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand text-uppercase" href="{{ route('dashboard') }}">
            {{ config('app.name', 'Travel Management System') }}
        </a>

        <!-- Sidebar Toggle -->
        <button id="sidebarToggle" class="btn btn-outline-light me-3">
            <i id="sidebarIcon" class="bi bi-list"></i>
        </button>

        <!-- 🔍 Global Search -->
        <form class="d-flex flex-grow-1 me-3" action="{{ route('dashboard') }}" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-secondary border-0 text-white">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="q"
                    class="form-control border-0"
                    placeholder="Search bookings, users, invoices..."
                >
            </div>
        </form>



        <!-- Right Side -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <span
                        id="liveDateTime"
                        class="nav-link text-white fw-semibold small"
                        style="white-space: nowrap;"
                    >
                        --:--:--
                    </span>
                </li>

                @php
                    $authUser = session('auth_user');
                @endphp

                @if($authUser && $authUser->role === 'admin')
                    <li class="nav-item me-3">
                        <button
                            class="btn btn-outline-light position-relative"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#activeUsersCanvas"
                            aria-controls="activeUsersCanvas"
                        >
                            <i class="bi bi-people-fill"></i>

                            <!-- Active users count -->
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                {{ $activeUsersCount ?? 0 }}
                            </span>
                        </button>
                    </li>
                @endif


                <!-- 🔔 Notifications -->
                <li class="nav-item me-3">
                    <button
                        class="btn btn-outline-light position-relative"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#notificationCanvas"
                    >
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </button>
                </li>

                <!-- User -->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle text-white text-uppercase"
                        href="#"
                        id="userDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="bi bi-person-circle me-1"></i>
                        {{ session('auth_user')->name ?? '' }}
                        ({{ ucfirst(session('auth_user')->role ?? '') }})
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <!-- Profile -->
                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        <!-- Settings -->
                        <li>
                            <a class="dropdown-item" href="{{ route('settings') }}">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <!-- Logout -->
                        <li>
                            <a
                                class="dropdown-item text-danger fw-bold"
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#logoutConfirmModal"
                            >
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
