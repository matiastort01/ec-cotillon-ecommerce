@include ('user-log.header-log-in')

<main class="container">
    <div class="loginCard row">
        <div class="cardLeft col-6 d-sm-block d-none">
            <div class="imageCover">
                <img src="{{ asset('images/register.png') }}" alt="Verification Code Image" class="decorativeImage">
            </div>
        </div>
        <div class="cardRight col-sm-6 col-12">
            <h1 class="titleLogin">EC-Cotillon</h1>
            <h2 class="welcomeText">Ingresa el código de verificación</h2>

            <!-- Mensaje -->
            @if (session('success_reenviar'))
                <div class="alert alert-success">
                    {{ session('success_reenviar') }}
                </div>
            @else
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('code_error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('code_error') }}
                    </div>
                @endif
            @endif
            

            <form action="{{ route('user-log.verificar_codigo', $usuario->id_usuario) }}" method="POST" id="verifyCodeForm">
                @csrf

                <!-- Código de Verificación -->
                <div id="inputGroupCode">
                    <label for="verification_code" id="labelCode">Código de Verificación</label>
                    <input type="text" id="verification_code" name="verification_code" placeholder="Ingresa el código de verificación" autocomplete="off" value="{{ old('verification_code') }}">

                    @error('verification_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Verificación -->
                <button type="submit" id="boton" class="btn btn-block mt-4">Verificar Código</button>

                <!-- Enlace a Login -->
                <div class="mt-3 text-center">
                    <p class="text-dark">¿No recibiste el código? <a href="{{ route('user-log.reenviar_codigo', ['usuario' => $usuario->id_usuario]) }}" class="text-info">Reenviar el código</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

@include ('user-log.footer-log-in')
