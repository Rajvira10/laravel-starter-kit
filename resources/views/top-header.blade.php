<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">

            <div class="d-flex">

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">

                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/avatar-demo.png') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->guard('web')->user()->first_name }}
                                    {{ auth()->guard('web')->user()->last_name }}</span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome {{ auth()->guard('web')->user()->first_name }} !</h6>
                        @if (auth()->guard('web')->user()->role->name == 'Super Admin')
                            <a href="{{ route('settings.index') }}"><button class="dropdown-item" type="submit"><i
                                        class=" ri-settings-3-fill text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Settings</span></button></a>
                        @endif
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>

<script>
    const lightDarkMode = document.querySelector('.light-dark-mode');

    lightDarkMode.addEventListener('click', () => {
        const currentMode = sessionStorage.getItem('data-layout-mode') || 'light';
        console.log(currentMode);
        sessionStorage.setItem('data-layout-mode', currentMode === 'dark' ? 'light' : 'dark');
    });
</script>
