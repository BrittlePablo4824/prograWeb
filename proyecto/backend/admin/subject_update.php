<?php
session_start();
require_once "../config/db.php";


// Validamos que sea correctamente administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    echo "Acceso denegado";
    exit;
}

$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? "";

// Validaciones básicas para que ingrese los datos correctamente
if (!$id || !$nombre) {
    echo "Datos incompletos.";
    exit;
}

// Actualizamos la materia
$stmt = $pdo->prepare("UPDATE subjects SET nombre = ? WHERE id = ?");
$stmt->execute([$nombre, $id]);

// Volvemos al panel de materias
header("Location: /proyecto/frontend/dashboards/admin/manage_subjects.php?msg=actualizado");
exit;
