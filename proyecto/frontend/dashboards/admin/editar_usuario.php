<?php
session_start();

// Validar administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

require_once "/proyecto/backend/config/db.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "Usuario no válido.";
    exit;
}

// Obtenemos los datos del usuario
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Editar Usuario</h2>

    <a href="manage_users.php" class="btn btn-secondary mb-3">← Volver</a>

    <form action="/proyecto/backend/admin/update_user.php" method="POST" class="card p-4 shadow-sm">

        <!-- Ocultamos el ID -->
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?php echo $usuario['nombre']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="email" class="form-control"
                   value="<?php echo $usuario['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol:</label>
            <select name="role" class="form-select">
                <option value="student" <?php if($usuario["role"]=="student") echo "selected"; ?>>Estudiante</option>
                <option value="teacher" <?php if($usuario["role"]=="teacher") echo "selected"; ?>>Maestro</option>
                <option value="admin" <?php if($usuario["role"]=="admin") echo "selected"; ?>>Administrador</option>
            </select>
        </div>

         <!-- Guardamos los cambios -->
        <button class="btn btn-primary">Guardar Cambios</button>

    </form>
</div>

</body>
</html>
