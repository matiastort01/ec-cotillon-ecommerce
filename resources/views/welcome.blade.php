@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <div class="swiper mb-5 bg-transparent">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="swiper-zoom-container">
                    <img src="{{ asset('images/promo-cotillon.png') }}" alt="Promoción Cotillón">
                </div>
            </div>

            <div class="swiper-slide">
                <div class="swiper-zoom-container">
                    <!-- <a href="{{ route('productos_por_categoria', ['id' => 11]) }}">
                        <img src="{{ asset('images/slider-pasteleria.png') }}" alt="Promoción Cotillón">
                    </a> -->

                    <form action="{{ route('search_products') }}" method="GET" class="hidden-form">
                        @csrf
                        <input type="hidden" name="categorias[]" value="{{ 11 }}">

                        <button type="submit" class="hidden-button">
                            <img src="{{ asset('images/slider-pasteleria.png') }}" alt="Promoción Cotillón">
                        </button>
                    </form>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="swiper-zoom-container">
                    <img src="{{ asset('images/carrousel-navidad.png') }}" alt="Promoción Cotillón">
                </div>
            </div>
        </div>

        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <div class="swiper-scrollbar"></div>
    </div>

    <div id="contenedor-productos">
        @include('productos_js', ['productos' => $productos])
    </div>

    <div id="contenedor-paginacion">
        @include('productos_paginacion', ['productos' => $productos])
    </div>
</main>

<style>
    /* Clases para el 2do slider */
    .hidden-form {
        height: 100%; /* Asegúrate de que ocupe todo el slide */
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .hidden-button {
        width: 100%;
        height: 100%;
        background: none; /* Para que el botón sea transparente */
        border: none; /* Para que no tenga borde */
        padding: 0;
    }

    body {
        background: linear-gradient(to bottom, #a2cadf, #ffffff 80%);
        background-repeat: no-repeat;
    }

    /* Estilo pastel para el botón 'Ver más' */
    .btn-pastel {
        background-color: #eb9ac0;
        color: white;
        border: none;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .btn-pastel:hover {
        background-color: #eb9ac0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-pastel:active {
        background-color: #eb9ac0;
        transform: scale(0.98);
    }

</style>

<script>
    var parrafosJQuery = $('p');

    console.log("Hola me estoy actualizando antes del event listener");

   document.addEventListener('click', function (e) {
    if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
        e.preventDefault(); // Previene la acción predeterminada del enlace (navegar a la URL del enlace).

        const url = e.target.href; // Obtiene la URL del enlace que se clickeó.

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Indica que la solicitud es una petición AJAX.
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Agrega el token CSRF.
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json(); // Procesa la respuesta como JSON.
        })
        .then(data => {
            // Actualizar productos
            document.getElementById('contenedor-productos').innerHTML = data.productos;

            // Actualizar paginación
            document.getElementById('contenedor-paginacion').innerHTML = data.paginacion;

            // Actualizar la URL del navegador
            window.history.pushState(null, '', url);
        })
        .catch(error => {
            console.error('Error al cargar los productos:', error);
        });
    }
});

    console.log("Hola me estoy actualizando despies del event listener");
</script>

@include('footer')
