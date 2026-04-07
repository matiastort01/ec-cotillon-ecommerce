<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validar los datos del formulario
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'mensaje' => 'required|string',
        ], [
            "required" => "Este campo es obligatorio!",
            "email" => "Se debe utilizar un correo válido!"
        ]);

        // Enviar el correo
        Mail::send('email-contact', $data, function ($message) use ($data) {
            $message->to('ec.cotillon@gmail.com')
                    ->subject('Nuevo mensaje de contacto');
        });

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Gracias por contactarnos. Te responderemos pronto.');
    }
}
