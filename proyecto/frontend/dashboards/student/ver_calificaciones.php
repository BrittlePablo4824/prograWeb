<?php
session_start();

// Validamos que el Usuario sea correctamente estudiante
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: ../../../login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

$student_id = $_SESSION["user_id"];

// 1. Obtenemos todas las calificaciones del estudiante desde la BD de nuestro proyecto
$stmt = $pdo->prepare("
    SELECT 
        subjects.nombre AS materia,
        activities.title AS actividad,
        grades.grade_value AS calificacion,
        grades.feedback AS retro,
        activities.weight AS peso
    FROM grades
    JOIN submissions ON submissions.id = grades.submission_id
    JOIN activities ON activities.id = submissions.activity_id
    JOIN subjects ON subjects.id = activities.subject_id
    WHERE submissions.student_id = ?
");
$stmt->execute([$student_id]);
$calificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupamos las calificaciones por materia
$materias = [];

foreach ($calificaciones as $c) {
    $materias[$c["materia"]][] = $c;
}

// Calculamos el promedio general del Estudiante
$total = 0;
$count = 0;

foreach ($calificaciones as $c) {
    $total += $c["calificacion"];
    $count++;
}

$promedio_general = $count > 0 ? round($total / $count, 2) : 0;
// Si el estudiante tiene promedio mayor o igual a 90, desbloquea el logro
if ($promedio_general >= 90) {
    $pdo->prepare("
        UPDATE users 
        SET logro_promedio = 1 
        WHERE id = ?
    ")->execute([$student_id]);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Calificaciones</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Mis Calificaciones</h2>
    <a href="/proyecto/frontend/dashboards/student/student_dashboard.php" class="btn btn-secondary mb-3">← Volver</a>

    <div class="alert alert-info">
        <strong>Promedio General:</strong> <?php echo $promedio_general; ?>
    </div>

    <?php if (empty($calificaciones)): ?>

        <div class="alert alert-warning">Aún no tienes calificaciones registradas.</div>

    <?php else: ?>

        <?php foreach ($materias as $nombre_materia => $califs): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong><?php echo $nombre_materia; ?></strong>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Actividad: </th>
                                <th>Calificación: </th>
                                <th>Ponderación: </th>
                                <th>Retroalimentación: </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $suma = 0;
                            $cantidad = 0;

                            foreach ($califs as $c):
                                $suma += $c["calificacion"];
                                $cantidad++;
                            ?>
                                <tr>
                                    <td><?php echo $c["actividad"]; ?></td>
                                    <td><?php echo $c["calificacion"]; ?></td>
                                    <td><?php echo $c["peso"]; ?>%</td>
                                    <td><?php echo $c["retro"]; ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="table-success">
                                <td colspan="4">
                                    <strong>Promedio de la materia: </strong>
                                    <?php echo round($suma / $cantidad, 2); ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>
</html>
