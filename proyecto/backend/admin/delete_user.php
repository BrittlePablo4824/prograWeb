<?php
session_start();
require_once "../config/db.php";


// Validamos que sea administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado.";
    exit;
}

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "ID inválido";
    exit;
}

// Borramos el usuario permanentemente
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

// Volvemos a la lista de usuarios
header("Location: /proyecto/frontend/dashboards/admin/manage_users.php?msg=eliminado");
exit;
