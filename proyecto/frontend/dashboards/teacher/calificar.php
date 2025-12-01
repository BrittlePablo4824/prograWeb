<?php
//Sirve para mostrar información de la entrega y permitir colocar una calificación
session_start();
require_once __DIR__ . "/../../../backend/config/db.php";

// Verificamos que el rol sea maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

// Obtenemos el ID de la entrega
$submission_id = $_GET["submission_id"] ?? null;

if (!$submission_id) {
    echo "Entrega no válida";
    exit;
}

// Obtenemos datos de la entrega
$stmt = $pdo->prepare("
    SELECT submissions.id,
           users.nombre AS student_name,
           submissions.delivery_file
    FROM submissions
    JOIN users ON users.id = submissions.student_id
    WHERE submissions.id = ?
");
$stmt->execute([$submission_id]);
$entrega = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entrega) {
    echo "Entrega no encontrada";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificar Entrega</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
<div class="container mt-4">

    <h2>Calificar Entrega</h2>

    <p><strong>Estudiante:</strong> <?php echo $entrega["student_name"]; ?></p>

    <p><strong>Archivo:</strong>
        <?php if ($entrega["delivery_file"]): ?>
            <a href="/proyecto/backend/uploads/<?php echo $entrega["delivery_file"]; ?>" target="_blank">Ver archivo</a>
        <?php else: ?>
            No subió ningún archivo
        <?php endif; ?>
    </p>

    <!-- Formulario de calificación -->
    <form action="/proyecto/backend/teacher/save_grade.php" method="POST">

    <!-- ID de la entrega -->
    <input type="hidden" name="submission_id" value="<?php echo $submission_id; ?>">

    <!-- ID de la actividad para regresar a ver_entregas -->
    <input type="hidden" name="actividad_id" value="<?php echo $_GET['actividad_id'] ?? 0; ?>">

    <div class="mb-3">
        <label class="form-label">Calificación (0 - 100):</label>
        <input type="number" name="grade_value" class="form-control" min="0" max="100" step="0.01" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Retroalimentación (opcional):</label>
        <textarea name="feedback" class="form-control" rows="4"></textarea>
    </div>

    <button class="btn btn-primary">Guardar Calificación</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>

</form>


</div>
</body>
</html>
