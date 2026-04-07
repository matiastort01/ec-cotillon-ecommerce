@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row align-items-center mb-5">
        <div class="col-md-6 text-center mb-3">
            <img src="{{ asset('images/oso-trasparente.png') }}" alt="Mission Image"
                 class="img-fluid rounded-circle shadow animated-oso"
                 id="oso">
        </div>
        <div class="col-md-6 text-center text-md-left">
            <h2 class="font-weight-bold text-pastel">Nuestra Misión</h2>
            <p class="lead text-muted">Crear oportunidades económicas que impulsen el potencial colectivo del país, brindando una plataforma eficiente y accesible para conectar vendedores y compradores.</p>
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6 order-md-2 text-center mb-3">
            <img src="{{ asset('images/pingu-transparente.png') }}" alt="Founding Story Image" class="img-fluid rounded-circle shadow">
        </div>
        <div class="col-md-6 order-md-1 text-center text-md-left">
            <h2 class="font-weight-bold text-pastel">Nuestra Historia</h2>
            <p class="lead text-muted">"En 2015, en el corazón de CABA, nació nuestra tienda de cotillón con un sueño: hacer de cada celebración un momento inolvidable. Empezamos con una pequeña selección de artículos y, con el tiempo, nos hemos convertido en el destino online para todo tipo de fiestas. Desde cumpleaños hasta bodas, ofrecemos productos de calidad y diversión, entregados directamente a tu puerta para que disfrutes sin preocupaciones. ¡Celebra con nosotros y haz que tu fiesta sea única!"</p>
        </div>
    </div>

    <hr style="border: 0; border-top: 1px solid #a09f9f; margin: 30px 0;">

    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-pastel">Nuestro Equipo</h2>
    </div>

    <div class="row text-center">

        <div class="col-md-3 mb-4">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/facu.png') }}" alt="Integrante 2" class="img-fluid rounded-circle mb-3 fixed-size-img">
            </div>
            <h5 class="font-weight-bold">Facundo Bove Hernandez</h5>
            <p class="text-muted">Estudiante de Ingenieria en Sistemas</p>
        </div>

        <div class="col-md-3 mb-4">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/chad.png') }}" alt="Integrante 2" class="img-fluid rounded-circle mb-3 fixed-size-img">
            </div>
            <h5 class="font-weight-bold">Juan Garrone</h5>
            <p class="text-muted">Estudiante de Ingenieria en Sistemas</p>
        </div>

        <div class="col-md-3 mb-4">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/mati.png') }}" alt="Integrante 2" class="img-fluid rounded-circle mb-3 fixed-size-img">
            </div>
            <h5 class="font-weight-bold">Matias Tort</h5>
            <p class="text-muted">Estudiante de Ingenieria en Sistemas</p>
        </div>

        <div class="col-md-3 mb-4">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/fabri.png') }}" alt="Integrante 2" class="img-fluid rounded-circle mb-3 fixed-size-img">
            </div>
            <h5 class="font-weight-bold">Fabrizio Lombardo</h5>
            <p class="text-muted">Estudiante de Ingenieria en Sistemas</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="font-weight-bold text-center mb-3">Contactanos</h2>

            {{-- Agrego el atributo novalidate al form para desactivar la validación automática del navegador.
            Se ve q tiene un JS q valida los campos del formulario antes de enviarlo y no muestra nuestro cartelito de error.
            Al desactivar la validacion, el formulario si o si se envia al backend y se valida ahi. --}}
            {{-- PODRIAMOS HACER LA VALIDACION ENTERA CON JS. PORQUE CUANDO SE ENVIA SE RECARGA LA PAGINA Y TE MANDA AL PRINCIPIO --}}

            <form action="{{ route('contacto.send') }}" method="POST" novalidate>
                @csrf
                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" value="{{ old('nombre') }}" autocomplete="off">

                    @error('nombre')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" value="{{ old('email') }}" autocomplete="off">

                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí...">{{ old('mensaje') }}</textarea>

                    @error('mensaje')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-pastel btn-block">Enviar</button>
            </form>
        </div>
    </div>
</main>

@include('footer')

<!-- Estilos específicos -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .btn-pastel {
        background: linear-gradient(90deg, #fcb3c7, #ffb6c1);
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 50px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-pastel:hover {
        background: linear-gradient(90deg, #ff9da3, #ffa3ad);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .btn-pastel:active {
        transform: translateY(1px);
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
    }

    /* Centrar el botón */
    .form-group + .btn-pastel {
        display: block;
        margin: 2rem auto 0;
        width: fit-content;
    }

    .fixed-size-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
</style>






