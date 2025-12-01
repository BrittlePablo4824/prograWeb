<?php
session_start();
require_once "../config/db.php";


// Validamos que el usuario sea administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado";
    exit;
}

// Obtenemos todas las materias
$stmt = $pdo->query("
    SELECT subjects.id, subjects.nombre, subjects.descripcion,
           users.nombre AS teacher_name
    FROM subjects
    LEFT JOIN users ON users.id = subjects.teacher_id
");

$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtenemos la lista de maestros para asignar materias
$stmt2 = $pdo->query("SELECT id, nombre FROM users WHERE role = 'teacher'");
$maestros = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="/proyecto/frontend/dashboards/admin/admin_dashboard.php"
       class="btn btn-secondary mb-3">← Volver</a>

    <!-- ============================
         FORMULARIO PARA CREAR MATERIA
         ============================ -->
    <div class="card p-4 mb-4">
        <h4>Crear Nueva Materia</h4>

        <form action="subject_create.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre de la materia:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Asignar Maestro:</label>
                <select name="teacher_id" class="form-select">
                    <option value="">Sin maestro asignado</option>
                    <?php foreach ($maestros as $m): ?>
                        <option value="<?php echo $m["id"]; ?>">
                            <?php echo $m["nombre"]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn btn-primary">Crear Materia</button>
        </form>
    </div>

    <!-- ============================
         LISTA DE MATERIAS EXISTENTES
         ============================ -->

    <h4>Materias Registradas</h4>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Materia</th>
                <th>Descripción</th>
                <th>Profesor Asignado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($materias as $mat): ?>
            <tr>
                <td><?php echo $mat["id"]; ?></td>
                <td><?php echo $mat["nombre"]; ?></td>
                <td><?php echo $mat["descripcion"]; ?></td>
                <td><?php echo $mat["teacher_name"] ?? "Sin asignar"; ?></td>

                <td>
                    <a href="subject_edit.php?id=<?php echo $mat['id']; ?>"
                       class="btn btn-sm btn-warning">Editar</a>

                    <a href="subject_delete.php?id=<?php echo $mat['id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Eliminar esta materia?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>

</body>
</html>
