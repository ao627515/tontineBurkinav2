<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav d-flex justify-content-center  w-75">
        @if ($isShowTontine)
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="{{ route('home') }}" wire:navigate role="button"><i
                        class="fa-solid fa-arrow-left font-title"></i></a>
            </li>
        @endif
        <li class="nav-item">
            <h5 class="nav-link m-0 font-weight-bold font-title">
                {{ $page }}
            </h5>
        </li>
    </ul>
    @if ($isShowTontine)
        <ul class="navbar-nav w-25 d-flex @if(!$tontineIsStarted)  justify-content-around @else justify-content-end  @endif">
            <li wire:click='openTontineInfo' class="nav-item w-25">
                @if (!$tontineInfoIsOpen)
                    <div class="rounded-circle bg-danger" id="info-ux" style="height: 8px; width: 8px;"></div>
                @endif
                <i class="fa-solid fa-circle-info font-title "></i>
            </li>
            @if (!$tontineIsStarted)
                <li wire:click='editTontine' class="nav-item w-25"><i class="fa-solid fa-pen font-title"></i></li>
                <li wire:click='deleteTontine' class="nav-item w-25"><i class="fa-solid fa-trash font-title"></i></li>
            @endif
            <li class="nav-item w-25"><i class="fa-solid fa-bell font-title @if (!$tontineInfoIsOpen) mt-2 @endif"></i></li>
        </ul>
    @endif
</nav>
<!-- /.navbar -->
