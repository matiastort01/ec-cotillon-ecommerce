@include ('user-log.header-log-in')

    <main class="container">
        <div class="loginCard row">
            <div class="cardLeft col-6 d-sm-block d-none">
                <div class="imageCover">
                    <img src="{{ asset('images/sing-up.png') }}" alt="Decorative Furniture Image" class="decorativeImage">
                </div>
            </div>
            <div class="cardRight col-sm-6 col-12 box-sizing-border-box">
                <h1 class="titleLogin">EC-Cotillon</h1>
                <h2 class="welcomeText">Bienvenido a EC-COTILLON</h2>

                <!-- Mensaje -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('login_error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <form action="{{ route('user-log.register_remake') }}" method="POST" id="registerForm">
                    @csrf

                    <!-- Nombre de Usuario -->
                    <div id="inputGroupUsername">
                        <label for="register_username" id="labelUsername">Nombre de Usuario</label>
                        <input type="text" name="register_username" id="register_username" placeholder="Elige un nombre de usuario" value="{{ old('register_username') }}" autocomplete="off">

                        @error('register_username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div id="inputGroupEmail">
                        <label for="register_email" id="labelEmail">Email</label>
                        <input type="text" id="register_email" name="register_email" placeholder="Ingrese un email" value="{{ old('register_email') }}" autocomplete="off">

                        @error('register_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- la clase g-0 elimina el gutter entre las columnas dentro de la fila. Esto asegura que las columnas se ajusten perfectamente al contenedor padre, sin dejar espacios innecesarios o provocar desbordes. --}}

                    <div class="row g-0">
                        <!-- Contraseña -->
                        <div class="col-lg-6 col-12 pr-lg-2" id="inputGroupPassword">
                            <label for="register_password" id="labelPassword">Contraseña</label>
                            <input type="password" name="register_password" id="register_password" placeholder="Crear contraseña">
                            @error('register_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="col-lg-6 col-12 pl-lg-2" id="inputGroupConfirmPassword">
                            <label for="register_password_confirmation" id="labelConfirmPassword">Confirmar contraseña</label>
                            <input type="password" name="register_password_confirmation" id="register_password_confirmation" placeholder="Confirmar contraseña">
                            @error('register_password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <button type="submit" id="boton" class="btn btn-block mt-2">Registrarse</button>

                    <!-- Enlace a Login -->
                    <div class="mt-3 text-center">
                        <p class="text-dark">¿Ya tienes cuenta? <a href="{{ route('user-log.r_view_login_remake') }}" class="text-info">Inicia sesión aquí</a></p>
                    </div>

                </form>
            </div>
        </div>
    </main>

@include ('user-log.footer-log-in')
