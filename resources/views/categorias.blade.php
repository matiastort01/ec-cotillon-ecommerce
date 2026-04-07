@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <h1 class="mb-3">Categorías</h1>

    @if($categorias->isEmpty())
        <p>No hay categorías disponibles.</p>
    @else
        <div class="row">
            @foreach($categorias as $categoria)
                <div class="col-md-4 mb-4">
                    <div class="card">

                        {{-- <a href="{{ route('productos_por_categoria', $categoria->id_categoria) }}">
                            <img src="{{ asset($categoria->url_categoria) }}" class="card-img-top card-image-cat" alt="{{ $categoria->nombre_categoria }}">
                        </a> --}}
                        
                        <form action="{{ route('search_products') }}" method="GET" class="hidden-form">
                            @csrf
                            <input type="hidden" name="categorias[]" value="{{ $categoria->id_categoria }}">

                            <button type="submit" class="hidden-button w-100">
                                <img src="{{ asset($categoria->url_categoria) }}" class="card-img-top card-image-cat" alt="{{ $categoria->nombre_categoria }}">
                            </button>
                        </form>
                        <div class="card-body">
                            <h5 class="card-title">{{ $categoria->nombre_categoria }}</h5>
                            <!-- Descripción de la categoría -->
                            <p class="card-text">{{ $categoria->descripcion_categoria }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación aquí -->

        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">

                    @if ($categorias->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $categorias->previousPageUrl() }}" class="page-link">Anterior</a>
                        </li>
                    @endif


                    @for ($i = 1; $i <= $categorias->lastPage(); $i++)
                        <li class="page-item {{ $i == $categorias->currentPage() ? 'active' : '' }}">
                            <a href="{{ $categorias->url($i) }}" class="page-link">{{ $i }}</a>
                        </li>
                    @endfor


                    @if ($categorias->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $categorias->nextPageUrl() }}" class="page-link">Siguiente</a>
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
</main>

<style>
    .hidden-form {
        margin: 0;
        padding: 0;
    }

    .hidden-button {
        background: none; /* Para que el botón sea transparente */
        border: none; /* Para que no tenga borde */
        padding: 0;
    }
</style>

@include('footer')
