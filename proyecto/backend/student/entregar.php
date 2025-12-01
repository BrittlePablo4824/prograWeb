<?php
session_start();
require_once __DIR__ . "/../config/db.php";


// 1. Validamos que sea estudiante el Usuario
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    echo "Acceso denegado";
    exit;
}

$student_id = $_SESSION["user_id"];
$activity_id = $_POST["activity_id"] ?? null;

// Validamos la actividad del estudihambre
if (!$activity_id) {
    echo "Actividad no válida";
    exit;
}

// 2. Antes de guardar, obtenemos la fecha límite de la actividad
$stmt_fecha = $pdo->prepare("SELECT due_date FROM activities WHERE id = ?");
$stmt_fecha->execute([$activity_id]);
$actividad = $stmt_fecha->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    echo "Actividad no encontrada";
    exit;
}

$fecha_limite = $actividad["due_date"]; // <-- ya existe 🎉

// 3. Manejo del archivo que sube el estudiante
$file_name = null;

if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === 0) {

    $file_tmp = $_FILES["archivo"]["tmp_name"];
    $file_name = time() . "_" . $_FILES["archivo"]["name"];
    $destino = "proyecto/backend/uploads/" . $file_name;

    move_uploaded_file($file_tmp, $destino);
}

// 4. Guardamos o actualizamos la entrega
$stmt = $pdo->prepare("
    INSERT INTO submissions (activity_id, student_id, delivery_file)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        delivery_file = VALUES(delivery_file),
        submitted_at = NOW()
");

$stmt->execute([$activity_id, $student_id, $file_name]);

// 5. Verificar si fue entregada a tiempo (LOGRO opcional)
if (date("Y-m-d") <= $fecha_limite) {
    $pdo->prepare("UPDATE users SET logro_tiempo = 1 WHERE id = ?")
        ->execute([$student_id]);
}

// 6. Redirigimos al estudiante
header("Location: /proyecto/frontend/dashboards/student/ver_actividades.php?msg=entregado&id=$activity_id");
exit;
