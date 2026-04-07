@include('header-user')

<main class="container flex-grow-1 margin-top-100">
    <h1 class="text-center text-pastel mb-4">Agregar Nueva Categoría</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="url_categoria" class="font-weight-bold">Imagen</label>
            <input type="file" class="form-control" id="url_categoria" name="url_categoria" accept="image/*" onchange="previewImage(event)">

            @error('url_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 new-image" id="preview-container">
            <img id="nueva_imagen" src="#" alt="Imagen" class="img-fluid" style="max-width: 150px; max-height: 150px;">
        </div>

        <div class="form-group mb-3">
            <label for="nombre_categoria" class="font-weight-bold">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="{{ old('nombre_categoria') }}" autocomplete="off">

            @error('nombre_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="descripcion_categoria" class="font-weight-bold">Descripción</label>
            <textarea class="form-control" id="descripcion_categoria" name="descripcion_categoria">{{ old('descripcion_categoria') }}</textarea>

            @error('descripcion_categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-pastel btn-lg w-100 mb-3">Agregar Categoría</button>

        <!-- Botón de cancelar -->
        <a href="{{ route('admin.categorias') }}" class="btn btn-secondary btn-lg w-100">Cancelar</a>
    </form>
</main>

<style>

    .new-image {
        display: none;
    }

    .text-pastel {
        color: #8bd3f7;
    }

    /* Clase para el botón pastel */
    .btn-pastel {
        background-color: #8bd3f7;
        color: white;
        border: none;
    }

    .btn-pastel:hover {
        background-color: #b8def0;
    }
</style>

@include('footer')
