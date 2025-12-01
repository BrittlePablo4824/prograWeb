<?php
// Validamos el administrador
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
header("Location: http://localhost/proyecto/frontend/dashboards/admin/admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Panel del Administrador</h2>
    <p>Bienvenido, <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>

    <div class="list-group">

        <!-- Gestión de los usuarios -->
        <a href="manage_users.php"
           class="list-group-item list-group-item-action">
            Gestionar Usuarios
        </a>

        <!-- Gestión de las materias -->
        <a href="manage_subjects.php"
           class="list-group-item list-group-item-action">
           Gestionar Materias
        </a>

        <!-- Cerrar sesión -->
        <a href="/proyecto/backend/logout.php"
           class="list-group-item list-group-item-action text-danger">
            Cerrar sesión
        </a>

    </div>

</div>

</body>
</html>
