<?php
//Este archivo muestra las materias del maestro, y cuando selecciona una materia muestra todas las actividades creadas.
session_start();

// Ruta correcta a la base de datos
require_once __DIR__ . "/../../../backend/config/db.php";

// Validamos el acceso del Maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

$teacherId = $_SESSION["user_id"];

// Obtenemos las materias del Maestro
$stmt = $pdo->prepare("SELECT id, nombre FROM subjects WHERE teacher_id = ?");
$stmt->execute([$teacherId]);   // ← AQUÍ ES LA CORRECCIÓN
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Si el maestro selecciona una materia, obtenemos sus actividades
$subject_id = $_GET["subject_id"] ?? null;
$actividades = [];

if ($subject_id) {
    $stmt = $pdo->prepare("SELECT id, title FROM activities WHERE subject_id = ?");
    $stmt->execute([$subject_id]);
    $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Calificaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Ver Calificaciones</h2>
    <p>Profesor: <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>

    <!-- Seleccionamos la materia -->
    <form method="GET" class="mb-3">
        <label class="form-label">Seleccione una materia:</label>
        <select name="subject_id" class="form-select" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($materias as $m): ?>
                <option value="<?php echo $m['id']; ?>" <?php if ($m['id'] == $subject_id) echo "selected"; ?>>
                    <?php echo $m['nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-primary mt-2">Ver Actividades</button>
    </form>

    <!-- Mostramos las actividades -->
    <?php if ($subject_id): ?>

        <h4>Actividades de esta materia</h4>

        <?php if (count($actividades) === 0): ?>
            <div class="alert alert-info">No hay actividades creadas.</div>
        <?php else: ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Calificar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actividades as $act): ?>
                <tr>
                    <td><?php echo $act['title']; ?></td>
                    <td>
                        <a href="/proyecto/frontend/dashboards/teacher/ver_entregas.php?actividad_id=<?php echo $act['id']; ?>" class="btn btn-success btn-sm">
                            Ver Entregas
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php endif; ?>

    <?php endif; ?>

    <a href="/proyecto/frontend/dashboards/teacher/teacher_dashboard.php" class="btn btn-secondary mt-3">⬅ Volver</a>
</div>

</body>
</html>
