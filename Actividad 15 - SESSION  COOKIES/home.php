<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

$color = $_SESSION["color"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
</head>

<body style="color: <?php echo htmlspecialchars($color); ?>;">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario"]); ?>!</h2>
    <p>Selecciona una opción:</p>
    <ul>
        <li><a href="sesiones.php" style="color: <?php echo htmlspecialchars($color); ?>;">Contador con Sesiones</a></li>
        <li><a href="cookies.php" style="color: <?php echo htmlspecialchars($color); ?>;">Contador con Cookies</a></li>
    </ul>

    <p><a href="logout.php" style="color: <?php echo htmlspecialchars($color); ?>;">Cerrar sesión</a></p>
</body>
</html>
