<?php
session_start();

// Validamos acceso del estudiante
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: ../../../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Panel del Estudiante</h2>
    <p>Hola, <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>

    <!-- Sección de Logros -->
    <div class="mt-3 mb-4">
        <h5>Mis Logros</h5>

        <?php
        $t = $_SESSION["logro_tiempo"] ?? 0;
        $p = $_SESSION["logro_promedio"] ?? 0;

        if ($t == 0 && $p == 0): ?>
            <p class="text-muted">Aún no tienes logros.</p>
        <?php endif; ?>

        <?php if ($t == 1): ?>
            <span class="badge bg-success">Cumplido a Tiempo</span>
        <?php endif; ?>

        <?php if ($p == 1): ?>
            <span class="badge bg-warning text-dark">Promedio Alto</span>
        <?php endif; ?>
    </div>

    <div class="list-group">
        <a href="http://localhost/proyecto/frontend/dashboards/student/ver_materias.php" class="list-group-item list-group-item-action">Ver Materias Disponibles</a>
        <a href="http://localhost/proyecto/frontend/dashboards/student/ver_solicitudes.php" class="list-group-item list-group-item-action">Mis Solicitudes</a>
        <a href="http://localhost/proyecto/frontend/dashboards/student/ver_actividades.php" class="list-group-item list-group-item-action">Mis Actividades</a>
        <a href="http://localhost/proyecto/frontend/dashboards/student/ver_calificaciones.php" class="list-group-item list-group-item-action">Mis Calificaciones</a>

        <a href="../../../backend/logout.php"
           class="list-group-item list-group-item-action text-danger">Cerrar sesión</a>
    </div>

</div>

</body>
</html>
