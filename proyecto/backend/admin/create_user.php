<?php
// Iniciamos la sesión para poder validar el rol del usuario
session_start();

// Incluimos la conexión a la base de datos
require_once "../config/db.php";


// Validamos que el usuario logueado sea ADMIN
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado. Solo el administrador puede realizar esta acción.";
    exit;
}

// Obtenemos los datos del formulario
$nombre = $_POST["nombre"] ?? "";
$email = $_POST["email"] ?? "";
$pass = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "student"; // Si no se envía el rol, por defecto será estudiante

// Validamos datos mínimos
if (!$nombre || !$email || !$pass) {
    echo "Faltan datos. Todos los campos son obligatorios.";
    exit;
}

// Ciframos la contraseña
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Verificamos que el email NO exista
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "El correo ya está registrado.";
    exit;
}

// Insertamos el nuevo usuario
$stmt = $pdo->prepare("INSERT INTO users (nombre, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$nombre, $email, $hash, $role]);

// Redirigirimos nuevamente al panel del administrador
header("Location: /proyecto/frontend/dashboards/admin/admin_dashboard.php?msg=usuario_creado");
exit;
?>
