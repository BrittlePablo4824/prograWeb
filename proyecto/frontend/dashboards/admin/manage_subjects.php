<?php
session_start();

// Validamos que sea administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

// Obtenemos todas las materias
$stmt = $pdo->query("SELECT * FROM subjects");
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Materias</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2>Gestionar Materias</h2>

    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">← Volver</a>

    <!-- FORMULARIO PARA CREAR LA MATERIA -->
    <div class="card p-4 mb-4 shadow-sm">
        <h4>Crear Materia</h4>

        <form action="/proyecto/backend/admin/subject_create.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de la Materia:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <button class="btn btn-primary">Agregar Materia</button>
        </form>
    </div>

    <!-- LISTA DE LAS MATERIAS -->
    <h4>Materias Registradas</h4>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($materias as $mat): ?>
            <tr>
                <td><?php echo $mat["id"]; ?></td>
                <td><?php echo $mat["nombre"]; ?></td>
                <td>
                    <a href="/proyecto/backend/admin/subject_delete.php?id=<?php echo $mat['id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Eliminar esta materia?')">
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
