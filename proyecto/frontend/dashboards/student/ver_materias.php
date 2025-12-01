<?php
session_start();

// Validamos acceso del estudiante
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: http://localhost/proyecto/frontend/login.html");
    exit;
}

// Cargar conexión a la BD usando ruta correcta
require_once __DIR__ . "/../../../backend/config/db.php";


// Obtener materias
$stmt = $pdo->query("SELECT * FROM subjects");
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materias Disponibles</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Materias Disponibles</h2>

    <a href="http://localhost/proyecto/frontend/dashboards/student/student_dashboard.php"
       class="btn btn-secondary mb-3">← Volver</a>

    <?php if (empty($materias)): ?>

        <div class="alert alert-info">
            No hay materias registradas todavía.
        </div>

    <?php else: ?>

        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Materia</th>
                <th>Acción</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($materias as $m): ?>
                <tr>
                    <td><?php echo $m["id"]; ?></td>
                    <td><?php echo $m["nombre"]; ?></td>
                    <td>
                        <a href="http://localhost/proyecto/backend/student/solicitar.php?subject_id=<?php echo $m['id']; ?>"
                           class="btn btn-primary btn-sm">
                            Solicitar Inscripción
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

    <?php endif; ?>

</div>

</body>
</html>
