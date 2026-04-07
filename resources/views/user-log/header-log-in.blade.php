<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EC-Cotillon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:wght@400;500&display=swap">

    <link rel="stylesheet" href="{{ asset('css/log-in.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="nav-header">

        {{-- Cuando se llega a sm, el p desaparece y el nav pasa de ubicar sus elementos por row a column, de forma tal que al ser align-items-center (al ser < sm ordena el eje principal) se centra la imagen y el h1 --}}

        <nav class="container d-flex flex-sm-row flex-column justify-content-between align-items-center">
            <div class="d-flex align-items-center justify-content-center">
                <a class="mr-3" href="{{ route('welcome') }}">
                    <img src="{{ asset('images/ec-cotillon-logo.png') }}" alt="Logo" class="nav-logo">
                </a>
                <h1 class="m-0">EC-Cotillon</h1>
            </div>

            <p class="d-sm-block d-none m-0">Todo para tus fiestas en un solo lugar</p>
        </nav>
    </header>


