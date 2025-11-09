<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

$color = $_SESSION["color"];

// Contador con sesión
if (!isset($_SESSION["contador_sesion"])) {
    $_SESSION["contador_sesion"] = 1;
} else {
    $_SESSION["contador_sesion"]++;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador con Sesiones</title>
</head>
<body style="color: <?php echo htmlspecialchars($color); ?>;">
    <h2>Contador con Sesiones</h2>
    <p>Has visitado esta página <?php echo $_SESSION["contador_sesion"]; ?> veces.</p>

    <p><a href="home.php" style="color: <?php echo htmlspecialchars($color); ?>;">Volver</a></p>
    <p><a href="logout.php" style="color: <?php echo htmlspecialchars($color); ?>;">Cerrar sesión</a></p>
</body>
</html>
