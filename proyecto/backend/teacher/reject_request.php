<?php
//Este archivo permite rechazar una solicitud y opcionalmente guardar una razón
session_start();

// Solo maestros pueden rechazar solicitudes
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "teacher") {
    echo "Acceso no autorizado";
    exit;
}

// Ruta correcta a la BD
require_once __DIR__ . "/../config/db.php";

// Recibir ID por GET (porque el enlace lo manda así)
$enrollmentId = $_GET["id"] ?? null;

// Razón opcional (si no se usa formulario)
$reason = $_GET["reason"] ?? "Sin especificar";

if (!$enrollmentId) {
    echo "Falta ID de solicitud";
    exit;
}

$teacherId = $_SESSION["user_id"];

// Rechazamos la actividad
$sql = "
    UPDATE enrollments
    SET status = 'rejected',
        reviewed_at = NOW(),
        reviewer_id = ?,
        reason_rejection = ?
    WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$teacherId, $reason, $enrollmentId]);

// Redirigir al panel del maestro
header("Location: /proyecto/frontend/dashboards/teacher/solicitudes_pendientes.php?msg=rejected");
exit;
