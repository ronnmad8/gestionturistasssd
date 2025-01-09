<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Contacto</title>
</head>
<body>
    <h1>¡Hola!</h1>
    <p>mensaje recibido de {{ $data['name'] }}, con email {{ $data['email'] }}:</p>
    <blockquote>{{ $data['message'] }}</blockquote>
</body>
</html>