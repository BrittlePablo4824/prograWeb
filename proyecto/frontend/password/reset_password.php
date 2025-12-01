<?php
$uid = $_GET["uid"] ?? null;
if (!$uid) { echo "Solicitud inválida"; exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5 col-md-4">

    <h3 class="mb-3">Nueva Contraseña</h3>

    <form action="/proyecto/backend/password/reset_password.php" method="POST">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>">

        <div class="mb-3">
            <label>Nueva contraseña:</label>
            <input type="password" name="pass" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Actualizar</button>
    </form>

</div>

</body>
</html>
