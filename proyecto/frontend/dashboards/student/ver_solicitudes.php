<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: ../../../login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

$student_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT 
        subjects.nombre AS materia,
        enrollments.status AS estado,
        enrollments.reason_rejection AS motivo
    FROM enrollments
    JOIN subjects ON subjects.id = enrollments.subject_id
    WHERE enrollments.student_id = ?
");
$stmt->execute([$student_id]);
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Solicitudes</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Mis Solicitudes</h2>
    <a href="student_dashboard.php" class="btn btn-secondary mb-3">← Volver</a>

    <?php if (empty($solicitudes)): ?>
        <div class="alert alert-info">Aún no envías solicitudes.</div>
    <?php else: ?>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Materia</th>
                    <th>Estado</th>
                    <th>Motivo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($solicitudes as $s): ?>
                    <tr>
                        <td><?= $s["materia"] ?></td>
                        <td>
                            <?php
                                if ($s["estado"] === "pending") echo "<span class='badge bg-warning text-dark'>Pendiente</span>";
                                elseif ($s["estado"] === "approved") echo "<span class='badge bg-success'>Aprobado</span>";
                                else echo "<span class='badge bg-danger'>Rechazado</span>";
                            ?>
                        </td>
                        <td><?= $s["motivo"] ?: "—" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    <?php endif; ?>

</div>

</body>
</html>
