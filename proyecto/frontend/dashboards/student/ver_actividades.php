<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: ../../../login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

$student_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT activities.*, subjects.nombre AS materia_nombre
    FROM activities
    JOIN subjects ON subjects.id = activities.subject_id
    WHERE subjects.id IN (
        SELECT subject_id FROM enrollments
        WHERE student_id = ? AND status = 'approved'
    )
");

$stmt->execute([$student_id]);
$actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Actividades</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
<div class="container mt-4">

    <h2 class="mb-3">Mis Actividades</h2>
    <a href="student_dashboard.php" class="btn btn-secondary mb-3">← Volver</a>

    <?php if (empty($actividades)): ?>
        <div class="alert alert-info">No hay actividades asignadas aún.</div>
    <?php else: ?>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Materia</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha Límite</th>
                    <th>Ponderación</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($actividades as $a): ?>
                    <tr>
                        <td><?= $a["materia_nombre"] ?></td>
                        <td><?= $a["title"] ?></td>
                        <td><?= $a["description"] ?></td>
                        <td><?= $a["due_date"] ?></td>
                        <td><?= $a["weight"] ?>%</td>

                        <td>
                            <a href="entregar_actividad.php?id=<?= $a['id'] ?>"
                               class="btn btn-primary btn-sm">
                                Entregar
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
