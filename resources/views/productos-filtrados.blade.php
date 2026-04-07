@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <h1 class="mb-3">Productos en {{ $categoria->nombre_categoria }}</h1>

    @if($productos->isEmpty())
        <p>No hay productos disponibles en esta categoría.</p>
    @else
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($producto->url_producto) }}" class="card-img-top card-image" alt="{{ $producto->nombre_producto }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombre_producto }}</h5> <!-- Ver h5 -->
                            <p class="card-text">{{ $producto->descripcion_producto }}</p>
                            <a href="{{ route('producto.show', $producto->id_producto) }}" class="btn btn-pastel">Ver más</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Add link para pasar a la siguiente página -->
    @endif

    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">

                @if ($productos->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $productos->previousPageUrl() }}" class="page-link">Anterior</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $productos->lastPage(); $i++)
                    <li class="page-item {{ $i == $productos->currentPage() ? 'active pastel-page' : '' }}">
                        <a href="{{ $productos->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor

                @if ($productos->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $productos->nextPageUrl() }}" class="page-link">Siguiente</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Siguiente</span>
                    </li>
                @endif

            </ul>
        </nav>
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
</style>

@include('footer')
