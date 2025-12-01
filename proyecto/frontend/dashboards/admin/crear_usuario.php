<?php
// Iniciamos la sesión para verificar si el usuario es administrador
session_start();

// Impedimos el acceso si el usuario no es admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Crear Nuevo Usuario</h2>

    <!-- Mostramos el nombre del administrador -->
    <p>Bienvenido, <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>

    <!-- Formulario para poder crear un usuario -->
    <form action="/proyecto/backend/admin/create_user.php" method="POST" class="card p-4 shadow-sm">

        <!-- Nombre del Usuario-->
        <div class="mb-3">
            <label class="form-label">Nombre Completo:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <!-- Email del Usuario-->
        <div class="mb-3">
            <label class="form-label">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- Contraseña del Usuario-->
        <div class="mb-3">
            <label class="form-label">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- Rol del Usuario-->
        <div class="mb-3">
            <label class="form-label">Rol del Usuario:</label>
            <select name="role" class="form-select">
                <option value="student">Estudiante</option>
                <option value="teacher">Maestro</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <!-- Botones -->
        <button class="btn btn-primary">Crear Usuario</button>
        <a href="/proyecto/frontend/admin/admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>

</div>

</body>
</html>
