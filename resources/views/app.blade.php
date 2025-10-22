<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry - MaVins</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/favicon.svg') }}" type="image/x-icon">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>

<body>
    <div id="app">

        @include('inc/sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>@yield('title')</h3>
                            <p class="text-subtitle text-muted">@yield('description')</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">@yield('page')</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="page-content">
                    @yield('content')
                </div>

                @include('inc/footer')
            </div>
        </div>
        <script src="{{ asset('assets/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/assets/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/assets/vendors/apexcharts/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/assets/js/pages/dashboard.js') }}"></script>

        <script src="{{ asset('assets/assets/js/main.js') }}"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        {{-- stack untuk script tambahan --}}
        @stack('scripts')
</body>

</html>
