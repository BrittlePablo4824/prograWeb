<?php
session_start();
require_once "../config/db.php";


// Validamos que sea admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado";
    exit;
}

$nombre = $_POST["nombre"] ?? "";

if (!$nombre) {
    echo "Falta el nombre de la materia.";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO subjects (nombre) VALUES (?)");
$stmt->execute([$nombre]);

// Volvemos a la página de materias
header("Location: /proyecto/frontend/dashboards/admin/manage_subjects.php");
exit;
