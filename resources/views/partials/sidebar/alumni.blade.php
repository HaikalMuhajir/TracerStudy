<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header text-center">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="m-0 text-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('argon/assets/img/logo-polinema.png') }}" width="52px" height="52px" class="mt-3"
                alt="main_logo">
            <p class="font-weight-bold">Tracer Study</p>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('alumni.dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span class="nav-link-text ms-1">Dashboard Alumni</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeMenu == 'kuesioner' ? 'active' : '' }}"
                    href="{{ route('alumni.kuesioner') }}">
                    <i class="fa fa-file-alt"></i>
                    <span class="nav-link-text ms-1">Isi Kuesioner</span>
                </a>
            </li>
            <br>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-sign-out-alt text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
