<?php
//Este archivo es para comprobar que el usuario sea maestro, consulta las materias que enseña el maestro y muestra un formulario para colocar los datos de las materias.
session_start();

// Cargar la BD (ruta correcta)
require_once __DIR__ . "/../../../backend/config/db.php";

// Validamos si el Usuario es maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

// Ésto es para obtener las materias que este maestro enseña
$stmt = $pdo->prepare("SELECT id, nombre FROM subjects WHERE teacher_id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Actividad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2>Crear Actividad</h2>
    <p>Profesor: <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>

    <!-- Formulario para crear actividad -->
    <form action="/proyecto/backend/teacher/create_activity.php" method="POST">

        <!-- Seleccionamos la materia -->
        <div class="mb-3">
            <label class="form-label">Materia:</label>
            <select name="subject_id" class="form-select" required>
                <option value="">Seleccione una materia</option>
                <?php foreach ($materias as $m): ?>
                    <option value="<?php echo $m['id']; ?>"><?php echo $m['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Colocamos el título a la act-->
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <!-- Colocamos la descripción a la act-->
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <!-- Colocamos la fecha límite a la act-->
        <div class="mb-3">
            <label class="form-label">Fecha Límite:</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <!-- Colocamos la ponderación a la act -->
        <div class="mb-3">
            <label class="form-label">Ponderación (%):</label>
            <input type="number" name="weight" class="form-control" step="0.01" min="0" max="100" required>
        </div>

        <!-- Botón enviar -->
        <button type="submit" class="btn btn-primary">Guardar Actividad</button>

        <!-- Volver -->
        <a href="/proyecto/frontend/dashboards/teacher/teacher_dashboard.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

</body>
</html>
