
<div class="row mt-5">
    @foreach($productos as $producto)
        <div class="col-md-4 mb-4">
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