@include('user-log.header-log-in')

<main class="container">
    <div class="loginCard row">
        <div class="cardLeft col-6 d-sm-block d-none">
            <div class="imageCover">
                <img src="{{ asset('images/register.png') }}" alt="Set New Password Image" class="decorativeImage">
            </div>
        </div>
        <div class="cardRight col-sm-6 col-12">
            <h1 class="titleLogin">EC-Cotillon</h1>
            <h2 class="welcomeText">Establece tu nueva contraseña</h2>

            <!-- Mensaje -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('password_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('password_error') }}
                </div>
            @endif

            <form action="{{ route('user-log.set_new_password', $usuario->id_usuario) }}" method="POST">
                @csrf

                <!-- Nueva Contraseña -->
                <div id="inputGroupPassword">
                    <label for="password" id="labelPassword">Nueva Contraseña</label>
                    <div class="row g-0">
                        <div class="col-10 pr-1">
                            <input type="password" id="password" name="password" placeholder="Ingresa tu nueva contraseña" autocomplete="new-password">
                        </div>
                        <div class="col-2 mt-1 pl-0">
                            <button type="button" onclick="togglePasswordVisibility()">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div id="inputGroupConfirmPassword">
                    <label for="password_confirmation" id="labelConfirmPassword">Confirmar Contraseña</label>
                    <div class="row g-0">
                        <div class="col-10 pr-1">
                            <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirma tu nueva contraseña" autocomplete="new-password">
                        </div>

                        <div class="col-2 mt-1 pl-0">
                            <button type="button" onclick="togglePasswordVisibility2()">
                                <i id="password-icon2" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>


                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Establecer Contraseña -->
                <button type="submit" id="boton" class="btn btn-block mt-4">Establecer Contraseña</button>

                <!-- Enlace a Login -->
                <div class="mt-3 text-center">
                    <p class="text-dark">¿Ya tienes cuenta? <a href="{{ route('user-log.r_view_login_remake') }}" class="text-info">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

<style>

    #inputGroupConfirmPassword button {
        width: 100%;
        height: calc(100% - 1px);
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    #inputGroupConfirmPassword button:hover {
        background-color: #e2e6ea;
    }

    #inputGroupPassword button {
        width: 100%;
        height: calc(100% - 1px);
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    #inputGroupPassword button:hover {
        background-color: #e2e6ea;
    }
</style>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const button = event.target;

        const icon = document.getElementById('password-icon');

        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Cambiar el ícono dependiendo del estado
        icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }

    function togglePasswordVisibility2() {
        const passwordInput = document.getElementById('confirm_password');
        const button = event.target;

        const icon = document.getElementById('password-icon2');

        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Cambiar el ícono dependiendo del estado
        icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }
</script>

@include ('user-log.footer-log-in')

{{--
@include('user-log.header-log-in')

<main class="container">
    <div class="loginCard row">
        <div class="cardLeft col-6 d-sm-block d-none">
            <div class="imageCover">
                <img src="{{ asset('images/register.png') }}" alt="Set New Password Image" class="decorativeImage">
            </div>
        </div>
        <div class="cardRight col-sm-6 col-12">
            <h1 class="titleLogin">EC-Cotillon</h1>
            <h2 class="welcomeText">Establece tu nueva contraseña</h2>

            <!-- Mensaje -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('password_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('password_error') }}
                </div>
            @endif

            <form action="{{ route('user-log.set_new_password', $usuario->id_usuario) }}" method="POST">
                @csrf

                <!-- Nueva Contraseña -->
                <div id="inputGroupPassword">
                    <label for="password" id="labelPassword">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu nueva contraseña" autocomplete="new-password">

                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div id="inputGroupConfirmPassword">
                    <label for="password_confirmation" id="labelConfirmPassword">Confirmar Contraseña</label>
                    <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirma tu nueva contraseña" autocomplete="new-password">

                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Establecer Contraseña -->
                <button type="submit" id="boton" class="btn btn-block mt-4">Establecer Contraseña</button>

                <!-- Enlace a Login -->
                <div class="mt-3 text-center">
                    <p class="text-dark">¿Ya tienes cuenta? <a href="{{ route('user-log.r_view_login_remake') }}" class="text-info">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

@include ('user-log.footer-log-in') --}}
