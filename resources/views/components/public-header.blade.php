<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('public.home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="assets/img/logo.png" alt="">
            {{-- <h1 class="sitename">Savora</h1> --}}
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li>
                    <a href="{{ route('public.home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Portada</a>
                </li>
                <li>
                    <a href="{{ route('public.about') }}"
                        class="nav-link {{ request()->is('about') ? 'active' : '' }}">Quienes Somos</a>
                </li>
                <li>
                    <a href="{{ route('public.minuta') }}"
                        class="nav-link {{ request()->is('minuta') ? 'active' : '' }}">Minuta Semanal</a>
                </li>
                <li><a href="{{ route('public.menu') }}"
                        class="nav-link {{ request()->is('menu') ? 'active' : '' }}">Haz tu pedido</a></li>
                <li><a href="{{ route('public.associated') }}"
                        class="nav-link {{ request()->is('associated') ? 'active' : '' }}">Comercio Asociado</a></li>
                <li><a href="{{ route('public.contact') }}"
                        class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contacto</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <span>&#32;</span>

        {{-- <a class="btn-getstarted d-none d-sm-block" href="#book-a-table">Book a Table</a> --}}

    </div>
</header>
