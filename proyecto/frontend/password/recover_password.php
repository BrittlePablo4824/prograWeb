<!-- Éste archivo servirá para que el Usuario tenga la posibilidad de Recuperar su Contraseña -->
<!DOCTYPE html>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5 col-md-4">

    <h3 class="mb-3">Recuperar Contraseña</h3>

    <form action="/proyecto/backend/password/recover_password.php" method="POST">

        <div class="mb-3">
            <label>Correo registrado:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Enviar</button>
    </form>

</div>

</body>
</html>
