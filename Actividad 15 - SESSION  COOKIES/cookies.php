<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

$color = $_SESSION["color"];

// Contador con cookies
if (!isset($_COOKIE["contador_cookie"])) {
    $contador = 1;
} else {
    $contador = $_COOKIE["contador_cookie"] + 1;
}
setcookie("contador_cookie", $contador, time() + 3600);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador con Cookies</title>
</head>
<body style="color: <?php echo htmlspecialchars($color); ?>;">
    <h2>Contador con Cookies</h2>
    <p>Has visitado esta página <?php echo $contador; ?> veces.</p>

    <p><a href="home.php" style="color: <?php echo htmlspecialchars($color); ?>;">Volver</a></p>
    <p><a href="logout.php" style="color: <?php echo htmlspecialchars($color); ?>;">Cerrar sesión</a></p>
</body>
</html>
