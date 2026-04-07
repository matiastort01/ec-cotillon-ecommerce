@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <h1 class="text-center text-info mb-4">Editar Categoría</h1>

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

    <!-- TODO: Configurar el msg del campo con JS -->
    <form action="{{ route('admin.categorias.update', $categoria->id_categoria) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Actualizo con metodo PUT idem DELETE -->

        <div class="form-group mb-3">
            <label for="url_categoria" class="font-weight-bold">Imagen del Producto</label>
            <input type="file" class="form-control" id="url_categoria" name="url_categoria" accept="image/*" onchange="previewImage(event)">

            @error('url_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="row">
                @if ($categoria->url_categoria)
                    <div class="col-6 mt-3">
                        <p>Imagen actual:</p>
                        <img src="{{ asset($categoria->url_categoria) }}" alt="Imagen categoria" class="img-fluid" style="max-width: 150px; max-height: 150px;">
                    </div>
                @endif

                <div class="col-6 mt-3 new-image" id="preview-container">
                    <p>Imagen nueva:</p>
                    <img id="nueva_imagen" src="#" alt="Imagen nueva" class="img-fluid" style="max-width: 150px; max-height: 150px;">
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="nombre_categoria" class="font-weight-bold">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="{{ old('nombre_categoria', $categoria->nombre_categoria) }}" autocomplete="off">

            @error('nombre_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="descripcion_categoria" class="font-weight-bold">Descripción</label>
            <textarea class="form-control" id="descripcion_categoria" name="descripcion_categoria">{{ old('descripcion_categoria', $categoria->descripcion_categoria) }}</textarea>

            @error('descripcion_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn pastel-primary btn-lg w-100 mb-3">Actualizar Categoría</button>

        <!-- Botón de cancelar -->
        <a href="{{ route('admin.categorias') }}" class="btn btn-secondary btn-lg w-100">Cancelar</a>
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
