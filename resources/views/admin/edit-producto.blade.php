@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <h1 class="text-center text-info mb-4">Editar Producto</h1> <!-- Cambiado a azul más claro -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.productos.update', $producto->id_producto) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="url_producto" class="font-weight-bold">Imagen del Producto</label>
            <input type="file" class="form-control" id="url_producto" name="url_producto" accept="image/*" onchange="previewImage(event)">

            @error('url_producto')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="row">
                @if ($producto->url_producto)
                    <div class="col-6 mt-3">
                        <p>Imagen actual:</p>
                        <img src="{{ asset($producto->url_producto) }}" alt="Imagen del Producto" class="img-fluid" style="max-width: 150px; max-height: 150px;">
                    </div>
                @endif

                <div class="col-6 mt-3 new-image" id="preview-container">
                    <p>Imagen nueva:</p>
                    <img id="nueva_imagen" src="#" alt="Imagen nueva" class="img-fluid" style="max-width: 150px; max-height: 150px;">
                </div>

            </div>

        </div>

        <div class="form-group mb-3">
            <label for="nombre_producto" class="font-weight-bold">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="{{ old('nombre_producto', $producto->nombre_producto) }}" autocomplete="off">

            @error('nombre_producto')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="descripcion_producto" class="font-weight-bold">Descripción</label>
            <textarea class="form-control" id="descripcion_producto" name="descripcion_producto">{{ old('descripcion_producto', $producto->descripcion_producto) }}</textarea>

            @error('descripcion_producto')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="precio" class="font-weight-bold">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}">

            @error('precio')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="stock" class="font-weight-bold">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}">

            @error('stock')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="estado" class="font-weight-bold">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="1" {{ $producto->estado == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $producto->estado == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="id_categoria" class="font-weight-bold">Categoría</label>
            <select class="form-control" id="id_categoria" name="id_categoria">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ $producto->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn pastel-primary btn-lg w-100 mb-3">Actualizar Producto</button>
        <a href="{{ route('admin.productos') }}" class="btn btn-secondary btn-lg w-100">Cancelar</a>
    </form>
</main>

<style>

    .new-image {
        display: none;
    }

    .text-info {
        color: #5bc0de !important;
    }

    .pastel-primary {
        background-color: #5bc0de !important;
        color: #fff !important;
        font-size: 1.2rem;
        padding: 0.75rem;
        border: none;
    }

    .pastel-primary:hover {
        background-color: #46a1c4 !important;
        transition: background-color 0.3s ease;
    }
</style>

@include('footer')

