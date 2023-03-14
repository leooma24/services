<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recuperar contraseña</title>
</head>

<body>
    <h1>Hola</h1>
    <p>Has recibido este correo porque quieres resetear tu contraseña en nuestro sitio</p>
    <div style="text-align: center">
        <a href="http://localhost:8080/#/public/resetear/{{$token}}">Resetear Contraseña</a>
    </div>
    <p>Este link expirará en 60 minutos</p>
    <p>Si no necesitas resetear tu contraseña, has caso omiso de este correo.</p>
    <p>Saludos</p>
</body>
</html>
