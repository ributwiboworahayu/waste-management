<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="https://ui-avatars.com/api/?name=app&color=7F9CF5&background=EBF4FF"
          type="image/x-icon">
    <title>
        {{ config('app.name') }} | @yield('title', '')
    </title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Booststrap Icons -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}"/>

    @stack('custom-css') <!-- Custom CSS Stack -->
    <style>
        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        html, body {
            height: 100%;
            background-image: url('https://cdn.pixabay.com/photo/2020/06/23/00/53/river-5330961_1280.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>
<body>
@auth
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('waste.units') }}">Unit (Satuan)</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('waste.liquid') }}">Cairan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('waste.index') }}">Semua Data</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('waste.index', ['type' => 'in']) }}">Data
                                    Masuk</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('waste.index', ['type' => 'out']) }}">Data
                                    Keluar</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img
                                src="{{ Auth::user()->detail->photo ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                alt="{{ Auth::user()->name }}"
                                class="profile-picture me-2">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                Profile
                            </a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endauth

<main class="container-fluid">
    @yield('content')
</main>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- JQuery -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<!-- DataTables JS -->
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('.dataTable').DataTable({
            responsive: true
        })

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Satuan',
            width: '100%' // Make sure the Select2 dropdown is full width
        })
    })
</script>

@stack('custom-js') <!-- Custom JS Stack -->
</body>
</html>
