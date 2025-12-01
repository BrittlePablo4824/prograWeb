<?php
session_start();

// Validamos que sea admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

// Obtenemos todos los usuarios registrados para poder configurarlos si queremos
$stmt = $pdo->query("SELECT * FROM users");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Gestionar Usuarios</h2>

    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">← Volver</a>
    <a href="crear_usuario.php" class="btn btn-primary mb-3">+ Crear Usuario</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?php echo $u["id"]; ?></td>
                <td><?php echo $u["nombre"]; ?></td>
                <td><?php echo $u["email"]; ?></td>
                <td><?php echo $u["role"]; ?></td>

                <td>
                    <a href="editar_usuario.php?id=<?php echo $u['id']; ?>"
                       class="btn btn-warning btn-sm">Editar</a>

                    <a href="/proyecto/backend/admin/delete_user.php?id=<?php echo $u['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Deseas eliminar este usuario?')">  
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

</div>

</body>
</html>
