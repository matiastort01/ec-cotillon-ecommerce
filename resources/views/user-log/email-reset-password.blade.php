<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>

    <!-- Incluir css no funciona, lo hacemo asi -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #f0cede;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .email-body {
            margin-top: 20px;
        }
        .email-body p {
            line-height: 1.6;
        }
        .email-body strong {
            color: #af5b82;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>

</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Recuperar contraseña</h2>
        </div>
        <div class="email-body">
            <p><strong>Código de verificación:</strong> {{ $codigo }}</p>
        </div>
        <div class="footer">
            <p>Este mensaje fue enviado desde Ec-Cotillón. Si no lo reconoces, por favor ignóralo.</p>
        </div>
    </div>
</body>
</html>