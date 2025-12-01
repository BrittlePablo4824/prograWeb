<?php
//Este archivo sirve para que el maestro vea las entregas de cada actividad.
session_start();
require_once __DIR__ . "/../../../backend/config/db.php";

// Validamos el Usuario del maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

$actividad_id = $_GET["actividad_id"] ?? null;
if (!$actividad_id) {
    echo "Actividad no válida";
    exit;
}

// Consulta para obtener todas las entregas de tareas
$stmt = $pdo->prepare("
    SELECT submissions.id AS submission_id,
           users.nombre AS student_name,
           submissions.submitted_at,
           submissions.delivery_file,
           grades.grade_value
    FROM submissions
    JOIN users ON users.id = submissions.student_id  
    LEFT JOIN grades ON grades.submission_id = submissions.id
    WHERE submissions.activity_id = ?
");
$stmt->execute([$actividad_id]);
$entregas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entregas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Entregas de la Actividad</h2>

    <?php if (count($entregas) === 0): ?>
        <div class="alert alert-info">Aún no hay entregas.</div>
    <?php else: ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Fecha entrega</th>
                <th>Archivo</th>
                <th>Calificación</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($entregas as $e): ?>
            <tr>
                <td><?php echo $e['student_name']; ?></td>
                <td><?php echo $e['submitted_at']; ?></td>

                <td>
                    <?php if ($e['delivery_file']): ?>
                        <a href="/proyecto/backend/uploads/<?php echo $e['delivery_file']; ?>" target="_blank">Ver archivo</a>
                    <?php else: ?>
                        Sin archivo
                    <?php endif; ?>
                </td>

                <td><?php echo $e['grade_value'] ?? "Sin calificar"; ?></td>

                <td>
            <a href="/proyecto/frontend/dashboards/teacher/calificar.php?submission_id=<?php echo $e['submission_id']; ?>&actividad_id=<?php echo $actividad_id; ?>"
            class="btn btn-primary btn-sm">
       Calificar
    </a>
</td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

    <a href="/proyecto/frontend/dashboards/teacher/ver_calificaciones.php" class="btn btn-secondary mt-3">⬅ Volver</a>

</div>

</body>
</html>
