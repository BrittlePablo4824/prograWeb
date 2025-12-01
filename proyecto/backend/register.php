<?php

require_once __DIR__ . "/config/db.php";

// Obtenemos datos del formulario
$nombre = $_POST["nombre"] ?? "";
$email = $_POST["email"] ?? "";
$pass = $_POST["password"] ?? "";

// Validamos campos vacíos
if (!$nombre || !$email || !$pass) {
    echo "Faltan datos";
    exit;
}

// Ciframos contraseña
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Insertamos usuario con rol por defecto = student
$stmt = $pdo->prepare("
    INSERT INTO users (nombre, email, password_hash, role)
    VALUES (?, ?, ?, 'student')
");

$stmt->execute([$nombre, $email, $hash]);

// Redirigimos al login
header("Location: http://localhost/proyecto/frontend/login.html");
exit;
?>
