<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EC-Cotillon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('css/data-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

</head>
<body class="d-flex flex-column vh-100">
    <header class="header-user">
        <nav class="navbar container d-flex flex-md-row flex-column justify-content-between align-items-center">

            <div class="d-flex align-items-center mb-md-0 mb-1">
                <a class="navbar-brand me-3 p-0" href="{{ route('welcome') }}">
                    <img src="{{ asset('images/ec-cotillon-logo.png') }}" alt="Logo" class="nav-logo">
                </a>
                <a class="nav-link me-3" href="{{ route('index_cat') }}">Categorias</a>
                <a class="nav-link me-3" href="{{ route('about-us') }}">Nosotros</a>

                @if(auth()->check())
                    @if(auth()->user()->role == 'admin')
                        <a class="nav-link me-3" href="{{ route('admin.abm-list') }}" style="color: white;">ABM</a>
                    @endif

                    <div class="dropdown">
                        <button class="nav-link mbtn btn-outline-light fw-bold" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->username}}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Si no está logueado, mostrar botón de Login -->
                    <a href="{{ route('user-log.r_view_login_remake') }}" class="nav-link me-3">Ingresá</a>
                @endif
            </div>

            <div class="d-flex align-items-center">
                <form class="search-form" action="{{ route('search_products') }}" method="GET">
                    <input class="form-control" type="search" name="producto" value="{{ request('producto') }}" placeholder="Buscar productos..." aria-label="Search">

                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </nav>
    </header>






















