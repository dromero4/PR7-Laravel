<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de contraseña</title>
</head>

<body>
    <p>Hola,</p>
    <p>Recibimos una solicitud para restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:</p>
    <p>
        <a href="{{ url('/passwordAfterMail') }}?token={{ urlencode($token) }}&email={{ urlencode($email) }}" style="display: inline-block; padding: 10px 15px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px;">
            Restablecer Contraseña
        </a>
    </p>
    <p>Este enlace expirará en 30 minutos.</p>
    <p>Si no realizaste esta solicitud, puedes ignorar este correo.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte</p>
</body>

</html>