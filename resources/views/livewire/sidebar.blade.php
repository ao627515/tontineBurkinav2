<div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">Tontine Burkina</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Nom Prénom(s)</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('home') }}" wire:navigate
                            class="nav-link @if (Route::is('home') or Route::is('tontine.show')) active @endif">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Accueil
                                @if (Route::is('tontine.show'))
                                    <i class=" fa-solid fa-eye"></i>
                                @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Tontines adhérées
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('participant.index') }}" class="nav-link @if (Route::is('participant.index')) active @endif" wire:navigate>
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Participants
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>
                                Notifications
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <p>
                                À propos
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>
                                FAQ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click='logout' class="nav-link btn bg-danger">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Déconnexion
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->

        </div>
        <!-- /.sidebar -->
    </aside>
</div>
