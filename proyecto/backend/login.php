<?php
session_start();
require_once __DIR__ . "/config/db.php";

// Recibir datos del formulario
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

// Buscar usuario
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Correo no registrado");
}

// Validar contraseña
if (!password_verify($password, $user["password_hash"])) {
    die("Contraseña incorrecta");
}

// Guardar variables en sesión
$_SESSION["user_id"]        = $user["id"];
$_SESSION["user_nombre"]    = $user["nombre"];
$_SESSION["user_role"]      = $user["role"];
$_SESSION["logro_tiempo"]   = $user["logro_tiempo"];
$_SESSION["logro_promedio"] = $user["logro_promedio"];

// Redirigir según rol
if ($user["role"] === "admin") {
    header("Location: http://localhost/proyecto/frontend/dashboards/admin/admin_dashboard.php");
    exit;
}

if ($user["role"] === "teacher") {
    header("Location: http://localhost/proyecto/frontend/dashboards/teacher/teacher_dashboard.php");
    exit;
}

// Estudiante por defecto
header("Location: http://localhost/proyecto/frontend/dashboards/student/student_dashboard.php");
exit;
?>
