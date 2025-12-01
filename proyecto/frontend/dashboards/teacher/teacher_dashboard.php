<?php
//Ésto es para Iniciar sesión y validar acceso al Usuario
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") { 
    // Validamos si alguien está logueado y si el rol es el correcto (profesor)
    header("Location: proyecto/frontend/login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Maestro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Panel del Maestro</h2>
    <p>Bienvenido, <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>  <!-- Título y Bienvenida -->

    <div class="list-group">
        <!-- Nos lleva al Dashboard/Pantalla de Solis Pendientes -->
        <a href="/proyecto/frontend/dashboards/teacher/solicitudes_pendientes.php" class="list-group-item list-group-item-action">Solicitudes Pendientes</a>

        <!-- Nos lleva al Dashboard/Pantalla de Crear Actividades -->
        <a href="/proyecto/frontend/dashboards/teacher/crear_actividad.php" class="list-group-item list-group-item-action">Crear Actividades</a>

        <!-- Nos lleva al Dashboard/Pantalla de Ver Calificaciones -->
        <a href="/proyecto/frontend/dashboards/teacher/ver_calificaciones.php" class="list-group-item list-group-item-action">Ver Calificaciones</a>

        <!-- Nos lleva al Dashboard/Pantalla de Cerrar Sesión -->
        <a href="/proyecto/backend/logout.php" class="list-group-item list-group-item-action text-danger">Cerrar sesión</a>
    </div>
</div>

</body>
</html>
