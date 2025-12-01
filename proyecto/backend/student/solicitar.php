<?php
session_start();

// RUTA CORRECTA A LA BASE DE DATOS
require_once __DIR__ . "/../config/db.php";


// 1. Validamos que el usuario esté logueado y sea estudiante
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    echo "Acceso denegado";
    exit;
}

// 2. Guardamos los datos del estudiante
$student_id = $_SESSION["user_id"];     // ID del estudiante logueado
$subject_id = $_GET["subject_id"] ?? null; // Materia solicitada

// 3. Validamos que la materia exista
if (!$subject_id) {
    echo "Materia no válida.";
    exit;
}

// 4. Insertamos en la tabla enrollments con estado 'pending'
$stmt = $pdo->prepare("
    INSERT INTO enrollments (student_id, subject_id, status)
    VALUES (?, ?, 'pending')
");

try {
    $stmt->execute([$student_id, $subject_id]);

    // 5. Redirigir al estudiante a ver sus solicitudes
    header("Location: /proyecto/frontend/dashboards/student/ver_solicitudes.php?msg=ok");
    exit;

} catch (PDOException $e) {
    echo "Ya habías solicitado esta materia.";
}
?>
