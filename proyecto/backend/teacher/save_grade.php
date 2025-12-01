<?php
//Recibe la calificación de la vista anterior
//Valida que sea un maestro
//Inserta o actualiza la nota
//Guarda también retroalimentación y fecha
//Redirige al maestro

session_start(); //Activa la sesión del maestro
require_once __DIR__ . "/../config/db.php";

// Solo maestros
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    echo "Acceso denegado";
    exit;
}

$submission_id = $_POST["submission_id"] ?? null;
$grade_value   = $_POST["grade_value"] ?? null;
$feedback      = $_POST["feedback"] ?? null;
$actividad_id  = $_POST["actividad_id"] ?? null;

if (!$submission_id || $grade_value === null || !$actividad_id) {
    echo "Datos incompletos";
    exit;
}

// Insertamos la calificación
$stmt = $pdo->prepare("
    INSERT INTO grades (submission_id, grade_value, feedback, graded_by, graded_at)
    VALUES (?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE
        grade_value = VALUES(grade_value),
        feedback = VALUES(feedback),
        graded_by = VALUES(graded_by),
        graded_at = NOW()
");

$stmt->execute([$submission_id, $grade_value, $feedback, $_SESSION["user_id"]]);

//Regresamos al maestro a la lista de entregas
header("Location: /proyecto/frontend/dashboards/teacher/ver_entregas.php?actividad_id=$actividad_id");
exit;
