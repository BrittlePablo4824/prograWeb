<?php
session_start();

// Validamos que el Usuario sea estudiante
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

require_once __DIR__ . "/../../../backend/config/db.php";

// Validamos ID de actividad (GET al entrar a la página)
$activity_id = $_GET["id"] ?? null;

if (!$activity_id) {
    echo "Actividad no válida.";
    exit;
}

// Obtenemos la info de la actividad
$stmt = $pdo->prepare("
    SELECT activities.title, activities.description, activities.due_date, subjects.nombre AS subject_name
    FROM activities
    JOIN subjects ON subjects.id = activities.subject_id
    WHERE activities.id = ?
");
$stmt->execute([$activity_id]);
$actividad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    echo "Actividad no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entregar Actividad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Entregar Actividad</h2>

    <a href="/proyecto/frontend/dashboards/student/ver_actividades.php" class="btn btn-secondary mb-3">← Volver</a>

    <div class="card p-4 shadow-sm">

        <h4><?php echo $actividad["title"]; ?> </h4>
        <p><strong>Materia:</strong> <?php echo $actividad["subject_name"]; ?></p>
        <p><strong>Fecha límite:</strong> <?php echo $actividad["due_date"]; ?></p>
        <p><strong>Descripción:</strong> <?php echo $actividad["description"]; ?></p>

        <hr>

        <form action="/proyecto/backend/student/entregar.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">

            <div class="mb-3">
                <label class="form-label">Subir archivo:</label>
                <input type="file" name="archivo" class="form-control" required>
            </div>

            <button class="btn btn-primary">Enviar Entrega</button>
        </form>

    </div>

</div>

</body>
</html>
