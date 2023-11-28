        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex justify-content-center  w-75">
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
            @hasSection('btn-back')
                <ul class="navbar-nav w-25 d-flex justify-content-around">
                    <li x-on:click="$wire.set('tontineInfo', true)"  class="nav-item"><i class="fa-solid fa-circle-info font-title"></i></li>
                    <li class="nav-item"><i class="fa-solid fa-pen font-title"></i></li>
                    <li class="nav-item"><i class="fa-solid fa-trash font-title"></i></li>
                    <li class="nav-item"><i class="fa-solid fa-bell font-title"></i></li>
                </ul>
            @endif
        </nav>
        <!-- /.navbar -->
