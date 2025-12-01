<?php
session_start();

// Validamos el administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: /proyecto/frontend/login.html");
    exit;
}

require_once "/proyecto/backend/config/db.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "Materia no válida.";
    exit;
}

// Obtenemos los datos de la materia
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->execute([$id]);
$materia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$materia) {
    echo "Materia no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Materia</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Editar Materia</h2>

    <a href="manage_subjects.php" class="btn btn-secondary mb-3">← Volver</a>

    <form action="/proyecto/backend/admin/subject_update.php" method="POST" class="card p-4 shadow-sm">

        <!-- Ocultamos el ID -->
        <input type="hidden" name="id" value="<?php echo $materia['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre de la Materia:</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?php echo $materia['nombre']; ?>" required>
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>

    </form>

</div>

</body>
</html>
