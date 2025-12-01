<?php
session_start();

// Solo maestros pueden aprobar al estudiante
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "teacher") {
    echo "Acceso no autorizado";
    exit;
}

// CONEXIÓN CORRECTA A LA BD
require_once __DIR__ . "/../config/db.php";

// Recibir ID mediante GET
$enrollmentId = $_GET["id"] ?? null;

if (!$enrollmentId) {
    echo "Falta ID de solicitud";
    exit;
}

$teacherId = $_SESSION["user_id"];

// Actualizamos la solicitud del estudiante
$sql = "
    UPDATE enrollments
    SET status = 'approved',
        reviewed_at = NOW(),
        reviewer_id = ?
    WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$teacherId, $enrollmentId]);

// Redirigir al panel del maestro
header("Location: /proyecto/frontend/dashboards/teacher/solicitudes_pendientes.php?msg=approved");
exit;
