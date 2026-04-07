@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <div class="row">
        <!-- Barra lateral -->
        <aside class="col-lg-3 col-md-4 mb-4">
            <div class="p-3 bg-light border">
                <form action="{{ route('search_products') }}" method="GET">
                    @csrf
                    <h4>Filtros</h4>

                    <!-- Mantener búsqueda -->
                    <input type="hidden" name="producto" value="{{ request('producto') }}">

                    <!-- Filtros de categoría -->
                    <h5 class="mb-1">Categorias:</h5>
                    @foreach($categorias as $categoria)
                        <div>
                            <input type="checkbox" name="categorias[]" value="{{ $categoria->id_categoria }}"
                                {{ in_array($categoria->id_categoria, request('categorias', [])) ? 'checked' : '' }}>
                            <label>{{ $categoria->nombre_categoria }}</label>
                        </div>
                    @endforeach

                    <!-- Filtros de precio -->
                    <h5 class="mt-2 mb-1">Precio:</h5>
                    <div class="mb-1">
                        <label for="precio_min">Precio mínimo:</label>
                        <input type="number" name="precio_min" value="{{ request('precio_min') >= 0 ? request('precio_min') : 0 }}" placeholder="0">
                    </div>
                    <div>
                        <label for="precio_max">Precio máximo:</label>
                        <input type="number" name="precio_max" value="{{ request('precio_max') <= $precioMax ? request('precio_max') : $precioMax }}" placeholder={{ $precioMax }}>
                    </div>

                    <!-- Botones -->
                    <button type="submit" class="btn btn-pastel w-100 mt-3" id="apply-filters">Aplicar filtros</button>
                    <a href="{{ route('search_products', ['producto' => request('producto')]) }}" class="btn btn-pastel w-100 mt-3">Restablecer filtros</a>
                </form>
            </div>
        </aside>

        <!-- Contenido principal -->
        <section class="col-lg-9 col-md-8">
            @if($productos->isEmpty())
                <div class="no-products-message">
                    <div class="message-content">
                        <p>Lo sentimos, pero no tenemos productos disponibles para el filtro aplicado.</p>
                        <a href="{{ route('welcome') }}" class="btn btn-pastel">Volver al inicio</a>
                    </div>
                </div>
            @else
                <h2 class="text-center mb-4">Resultados de la búsqueda</h2>
                <div class="row">
                    @foreach($productos as $producto)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
                            <div class="card">
                                <img src="{{ asset($producto->url_producto) }}" class="card-img-top card-image" alt="{{ $producto->nombre_producto }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                                    <p class="card-price mb-2">${{ $producto->precio }}</p>
                                    <p class="card-text">{{ $producto->descripcion_producto }}</p>
                                    <a href="{{ route('producto.show', $producto->id_producto) }}" class="btn btn-pastel">Ver más</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            @if ($productos->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Anterior</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $productos->appends(request()->query())->previousPageUrl() }}" class="page-link">Anterior</a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $productos->lastPage(); $i++)
                                <li class="page-item {{ $i == $productos->currentPage() ? 'active pastel-page' : '' }}">
                                    <a href="{{ $productos->appends(request()->query())->url($i) }}" class="page-link">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($productos->hasMorePages())
                                <li class="page-item">
                                    <a href="{{ $productos->appends(request()->query())->nextPageUrl() }}" class="page-link">Siguiente</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Siguiente</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </section>
    </div>
</main>


<style>
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

    .pagination .page-item.active .page-link {
        background-color: #9cd2eb;
        border-color: #a9dcf3;
        color: white;
    }

    .pagination .page-link {
        color: black;
        font-size: 1rem;
    }

    .pagination .page-item:hover .page-link {
        background-color: #f5f5f5;
        color: black;
    }
</style>

@include('footer')
