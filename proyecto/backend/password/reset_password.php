<?php
require_once "../config/db.php";

$uid  = $_POST["uid"] ?? null;
$pass = $_POST["pass"] ?? null;

if (!$uid || !$pass) {
    echo "Datos faltantes";
    exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
$stmt->execute([$hash, $uid]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contraseña Actualizada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container col-md-4 mt-5 text-center">

    <h3 class="mb-4 text-success">✔ Contraseña actualizada correctamente</h3>

    <p>Ya puedes iniciar sesión con tu nueva contraseña.</p>

    <a href="/proyecto/frontend/login.html" class="btn btn-primary mt-3 w-100">
        Ir a Iniciar Sesión
    </a>

</div>

</body>
</html>
