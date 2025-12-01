<?php
session_start();  //Empezamos la sesión del Usuario, osea que activa las variables de dicha sesión
require_once __DIR__ . "/../../../backend/config/db.php";  //Aquí importamos la conexión a la base de datos

// Validar acceso del maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {  //Para comprobar si alguien ya inició la sesión y que su rol sea "maestro"
    header("Location: ../login.html");  //Si no es maestro, lo manda al login directamente.
    exit;
}

$teacherId = $_SESSION["user_id"];  //Esto es para guardar el ID del maestro actualmente conectado

// Obtenemos las solicitudes PENDIENTES de materias del maestro
$sql = "
SELECT enrollments.id AS enrollment_id,
       users.nombre AS student_name,
       users.email,
       subjects.nombre AS subject_name
FROM enrollments
JOIN users ON users.id = enrollments.student_id
JOIN subjects ON subjects.id = enrollments.subject_id
WHERE enrollments.status = 'pending'
  AND subjects.teacher_id = ?
";

$stmt = $pdo->prepare($sql);  //Preparamos la consulta para ejecutarla
$stmt->execute([$teacherId]);  //Ejecutamos la consulta con el ID del maestro
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);  //Recogemos todas las solicitudes encontradas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Pendientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-3">Solicitudes Pendientes</h2>
    <p>Hola profesor <strong><?php echo $_SESSION["user_nombre"]; ?></strong></p>       <!-- Mostrará el nombre del maestro conectado -->

    <?php if (count($solicitudes) === 0): ?>      <!-- Validará si hay solicitudes o no-->
        <div class="alert alert-info">No hay solicitudes pendientes.</div>
    <?php else: ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Correo</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($solicitudes as $sol): ?>
            <tr>
                <td><?php echo $sol["student_name"]; ?></td>
                <td><?php echo $sol["email"]; ?></td>
                <td><?php echo $sol["subject_name"]; ?></td>
                <td>
                    <a href="/proyecto/backend/teacher/approve_request.php?id=<?php echo $sol["enrollment_id"]; ?>"
                       class="btn btn-success btn-sm">Aprobar</a>

                    <a href="/proyecto/backend/teacher/reject_request.php?id=<?php echo $sol["enrollment_id"]; ?>"
                       class="btn btn-danger btn-sm">Rechazar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

    <a href="/proyecto/frontend/dashboards/teacher/teacher_dashboard.php" class="btn btn-secondary mt-3">⬅ Volver al Panel del Maestro</a>      <!-- Botón para volver a la página principal del maestro -->

</div>

</body>
</html>
