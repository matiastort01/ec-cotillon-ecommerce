@include ('user-log.header-log-in')

<main class="container">
    <div class="loginCard row"> 
        <div class="cardLeft col-6 d-sm-block d-none">
            <div class="imageCover">
                <img src="{{ asset('images/recuperar-contrasena.png') }}" alt="Password Reset Image" class="decorativeImage">
            </div>
        </div>
        <div class="cardRight col-sm-6 col-12">
            <h1 class="titleLogin">EC-Cotillon</h1>
            <h2 class="welcomeText">Recupera tu contraseña</h2>

            <!-- Mensaje -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('reset_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('reset_error') }}
                </div>
            @endif

            <form action="{{ route('user-log.restaurar_password') }}" method="POST" id="resetPasswordForm">
                @csrf
                <div id="inputGroupUsername">
                    <label for="reset_username_or_email" id="labelUsername">Usuario o email</label>
                    <input type="text" id="reset_username" name="reset_username_or_email" placeholder="Ingrese un usuario o email" autocomplete="off" value="{{ old('reset_username_or_email') }}">

                    @error('reset_username_or_email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Botón de Recuperación -->
                <button type="submit" id="boton" class="btn btn-block mt-4">Recuperar Contraseña</button>

                <!-- Enlace a Login -->
                <div class="mt-3 text-center">
                    <p class="text-dark">¿Ya recordas tu contraseña? <a href="{{ route('user-log.r_view_login_remake') }}" class="text-info">Inicia sesión aquí</a></p>
                </div>

            </form>
        </div>
    </div>
</main>

<style>
</style>

@include ('user-log.footer-log-in')
