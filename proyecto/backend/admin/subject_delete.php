<?php
session_start();
require_once "../config/db.php";


// Validamos que sea admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado";
    exit;
}

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "ID inválido";
    exit;
}

// Eliminamos la materia
$stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ?");
$stmt->execute([$id]);

header("Location: /proyecto/frontend/dashboards/admin/manage_subjects.php");
exit;
