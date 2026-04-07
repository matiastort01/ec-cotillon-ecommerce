@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <div class="row d-flex justify-content-center">
        <div class="image-section col-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset($producto->url_producto) }}" alt="{{$producto->nombre_producto}}" class="img-fluid product-image">
        </div>
        <div class="details-section col-6 mt-4 p-3 line-p">
            <div class="name-section">
                <h1 class="product-title">{{$producto->nombre_producto}}</h1>
            </div>
            <div class="price-section mb-2">
                <div class="fs-3 text-muted product-price">${{$producto->precio}}</div>
            </div>
            <div class="description">
                <h2 class="fs-4 text-pastel">Descripción:</h2>
                <p>{{$producto->descripcion_producto}}</p>
            </div>
            <form action="">
                <div class="quantity-section mb-3 d-flex align-items-center">
                    <label for="quantity" class="me-2">Cantidad:</label>
                    <div class="select-wrapper">
                        <select id="quantity" class="form-select w-auto quantity-select">
                            @for ($i = 1; $i <= min($producto->stock, 5); $i++)
                                <option value="{{$i}}">{{$i}} unidad</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <!-- Botón Agregar al carrito -->
                    <button class="btn btn-outline-primary add-to-cart-btn">Agregar al carrito</button>
                    <!-- Nuevo botón Comprar -->
                    <a href="#" class="btn btn-outline-primary buy-now-btn">Comprar ahora</a>
                </div>
            </form>
        </div>
    </div>
</main>

@include('footer')

<style>
    /* General */
    .line-p {
        border: 0.2px solid #a39999;
        border-radius: 5px;
    }

    body {
        background-color: #fdfcfc; 
        color: #333; 
    }

    .container {
        max-width: 1200px;
        padding: 20px;
    }


    .text-pastel {
        color: #6ca3a4; 
    }

    .d-flex {
        display: flex;
    }

    .gap-2 {
        gap: 1rem; 
    }

    /* Ajustes para dispositivos móviles */
    @media (max-width: 768px) {
        .image-section, .details-section {
            flex: 1 1 100%;
            text-align: center;
        }
        
        .product-image {
            max-width: 90%;
        }
    }
</style>



