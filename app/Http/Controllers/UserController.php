<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Ramsey\Uuid\v1;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Producto;
use COM;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function r_view_login()
    {
        return view('user-log.login');
    }

    public function r_view_login_remake()
    {
        return view('user-log.login-remake');
    }

    public function r_view_register()
    {
        return view ('user-log.register');
    }

    public function r_view_register_remake()
    {
        return view('user-log.register-remake');
    }

    public function olvidar_contrasena()
    {
        return view('user-log.olvidar-contrasena');
    }

    public function restaurar_password(Request $request) {
        // Validar los datos del formulario
        $data = $request->validate([
            'reset_username_or_email' => 'required|string|max:255'
        ], [
            "required" => "Este campo es obligatorio!",
            "string" => 'El campo debe ser una cadena de texto válida.',
            "max" => 'El campo no puede superar los 255 caracteres.',
        ]);

        // Verificar si el valor ingresado es un correo electrónico
        $field = filter_var($data['reset_username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $usuario = User::where($field, $data['reset_username_or_email'])->first();

        if(!$usuario) {
            if($field === 'email') {
                return redirect(route('user-log.olvidar_contrasena'))->withErrors([
                    'reset_error' => 'No se encontró un usuario con ese email.'
                ])->withInput();
            }
            else {
                return redirect(route('user-log.olvidar_contrasena'))->withErrors([
                    'reset_error' => 'No se encontró un usuario con ese nombre.'
                ])->withInput();
            }
        }

        $token = Str::random(6);  /* Podriamos poner otra funcion */

        DB::table('password_reset_tokens')->where('username', $usuario->username)->delete();

        DB::table('password_reset_tokens')->insert([
            'username' => $usuario->username,
            'token' => $token,
        ]);

        // Enviar el correo
        Mail::send('user-log.email-reset-password', ['codigo' => $token], function ($user) use ($usuario) {
            $user->to($usuario->email)
                    ->subject('Recuperar contraseña');
        });

        // Redirigir con un mensaje de éxito
        return view('user-log.codigo-verificacion', ['usuario' => $usuario]);
        
        // return redirect(route('user-log.codigo-verificacion', ['usuario' => $usuario]))->with('success', 'El código ha sido enviado!'); 
    }

    public function reenviarCodigo($usuario_id) {
        // Buscar al usuario
        $usuario = User::findOrFail($usuario_id);

        // Generar o reutilizar el código de verificación
        $token_nuevo = Str::random(6); 

        DB::table('password_reset_tokens')->where('username', $usuario->username)->delete();

        DB::table('password_reset_tokens')->insert([
            'username' => $usuario->username,
            'token' => $token_nuevo,
        ]);

        // 
        Mail::send('user-log.email-reset-password', ['codigo' => $token_nuevo], function ($user) use ($usuario) {
            $user->to($usuario->email)
                    ->subject('Recuperar contraseña');
        });
        
        session()->flash('success_reenviar', 'El código de verificación ha sido reenviado correctamente.');
        
        // Redirigir  con un mensaje de éxito
        return view('user-log.codigo-verificacion', ['usuario' => $usuario]);
    }

    public function ingresar_codigo(User $usuario) {
        return view('user-log.codigo-verificacion', ['usuario' => $usuario]);
    }

    public function verificar_codigo(Request $request, User $usuario) {
        /* 
        $codigo_usuario = $request->validate([  
            'verification_code' => 'required|string|min:6|max:6'
        ], [
            "required" => "Este campo es obligatorio!",
            "min" => "El código tiene 6 caracteres!",
            "max" => "El código tiene 6 caracteres!"
        ]);
        
        Hay un error que no entendemos porque nos redirecciona todo el tiempo a la misma pagina.
        Haciendolo con valdiaror "manual" anda bien, asi que suponemos que debe haber un back detras de como lo hace laravel.
        */

        
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|min:6|max:6'
        ], [
            "required" => "Este campo es obligatorio!",
            "min" => "El código tiene 6 caracteres!",
            "max" => "El código tiene 6 caracteres!"
        ]);
    
        // Verificar si la validación falla
        if ($validator->fails()) {
            // Si falla, redirigir con errores y los datos de entrada
            return redirect()->route('user-log.ingresar_codigo', ['usuario' => $usuario])
                ->withErrors($validator)
                ->withInput();
        }
        
        $token = DB::table('password_reset_tokens')->where('username', $usuario->username)->value('token');

        if( $token === ($request['verification_code']) ){
            // si el codigo esta bien
            return redirect(route('user-log.set_new_password', ['usuario' => $usuario]))->with('success', 'El código es correcto!');
        }
        
        return redirect(route('user-log.ingresar_codigo', ['usuario' => $usuario]))->withErrors([
            'code_error' => 'El código es incorrecto. Vuelva a intentarlo.'
            ])->withInput();
        
    } 
 
    public function showSetNewPasswordForm(User $usuario) {
        return view('user-log.set-new-password', ['usuario' => $usuario]);
    }

    public function setNewPassword(Request $request, User $usuario)
    {
        // Validación de la nueva contraseña y confirmación
        $datos = $request->validate([
            "password" => ['required', 'confirmed', 'min:3', 'max:255']
        ], [
            "password.required" => "La contraseña es obligatoria.",
            "password.confirmed" => "Las contraseñas no coinciden.",
            "password.min" => "La contraseña debe tener al menos 6 caracteres.",
            "password.max" => "La contraseña no puede exceder los 255 caracteres."
        ]);

        $usuario->password = bcrypt($datos['password']);
        $usuario->save();

        // Redirigir con mensaje de éxito
        return redirect(route('user-log.r_view_login_remake'))->with('success', 'Tu contraseña ha sido actualizada correctamente.');
    }

    public function register(Request $request) {
        $datos = $request->validate([
            "register_username" => ['required', 'unique:usuarios,username', 'min:3', 'max:255'], 
            "register_password" => ['required', 'confirmed', 'min:6', 'max:255'],
            "register_email" => ['required', 'email', 'max:255']
        ], [
            "register_username.required" => "El nombre de usuario es obligatorio.",
            "register_username.unique" => "Este nombre de usuario ya está en uso.",
            "register_username.min" => "El nombre de usuario debe tener al menos 3 caracteres.",
            "register_username.max" => "El nombre de usuario no puede exceder los 255 caracteres.",
            "register_password.required" => "La contraseña es obligatoria.",
            "register_password.confirmed" => "Las contraseñas no coinciden.",
            "register_password.min" => "La contraseña debe tener al menos 6 caracteres.",
            "register_password.max" => "La contraseña no puede exceder los 255 caracteres.",
            "register_email.required" => "El nombre de usuario es obligatorio.",
            "email" => "Se debe utilizar un correo válido!",
            "register_email.max" => "El email no puede exceder los 255 caracteres."
        ]);

        // Encriptar la contraseña usando bcrypt
        $datos["register_password"] = bcrypt($datos["register_password"]);

        // Crear el nuevo usuario en la base de datos
        User::create([
            'username' => $datos['register_username'],
            'password' => $datos['register_password'],
            'role' => 'user',
            'email' => $datos['register_email']
        ]);

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('user-log.r_view_login_remake')->with("success", "Registro exitoso. Ahora puedes iniciar sesión.");
    }

    public function authenticate(Request $request) {
        $datos = $request->validate([
            'login_username_or_email' => 'required|string',  
            'login_password' => 'required|string',  
        ], [
            "required" => "Este campo es obligatorio!"
        ]);
    
        // Verificar si el valor ingresado es un correo electrónico
        $field = filter_var($datos['login_username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Intentar autenticar al usuario
        if (auth()->attempt([$field => $datos['login_username_or_email'], 'password' => $datos['login_password']])) {
            // Salió OK!
            return redirect()->route('welcome');
        } else {
            // Malio sal!
            return back()->withErrors([
                'login_error' => 'Nombre de usuario o contraseña incorrectos.',
            ])->withInput();  // Conservar los datos ingresados
        }
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect()->route('welcome'); 
    }
}
