<?php
session_start();
require_once "../config/db.php";


// Validamos que sea admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado.";
    exit;
}

$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? "";
$email = $_POST["email"] ?? "";
$role = $_POST["role"] ?? "";

if (!$id || !$nombre || !$email) {
    echo "Faltan datos.";
    exit;
}

// Actualizamos el usuario
$stmt = $pdo->prepare("
    UPDATE users 
    SET nombre = ?, email = ?, role = ?
    WHERE id = ?
");
$stmt->execute([$nombre, $email, $role, $id]);

header("Location: /proyecto/frontend/dashboards/admin/manage_users.php?msg=actualizado");
exit;
