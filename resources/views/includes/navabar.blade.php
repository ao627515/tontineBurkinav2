        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex justify-content-center  w-100">
                @hasSection('btn-back')
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="{{ route('home') }}" wire:navigate role="button"><i
                                class="fa-solid fa-arrow-left font-title"></i></a>
                    </li>
                @endif
                <li class="nav-item">
                    <h5 class="nav-link m-0 font-weight-bold font-title">
                        @yield('title')
                    </h5>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
