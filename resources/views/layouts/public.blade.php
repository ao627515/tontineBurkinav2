<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>{{ $title ?? 'Page Title' }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- css custom -->
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    @yield('css')
</head>
{{-- sidebar-mini-xs --}}
<body class=" layout-fixed layout-navbar-fixed" style="height: auto;">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        {{-- @include('includes.navabar') --}}
        @livewire('navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <livewire:sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 628.4px;">
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!--js customer-->
    @yield('scripts')
</body>

</html>
