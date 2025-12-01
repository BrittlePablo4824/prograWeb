<?php
//Éste archivo sirve para realizar la validación para que así los maestros puedan crear actividades
session_start();

// Cargar BD (ruta correcta)
require_once __DIR__ . "/../config/db.php";

// Validamos al usuario para verificar que es maestro
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    echo "Acceso no permitido";
    exit;
}

// Recibimos los datos del formulario
$subject_id  = $_POST["subject_id"] ?? null;
$title       = $_POST["title"] ?? null;
$description = $_POST["description"] ?? null;
$due_date    = $_POST["due_date"] ?? null;
$weight      = $_POST["weight"] ?? null;

// Validamos los datos mínimos
if (!$subject_id || !$title || !$due_date || !$weight) {
    echo "Faltan datos obligatorios";
    exit;
}

// Guardamos la actividad correctamente
$stmt = $pdo->prepare("
    INSERT INTO activities (subject_id, title, description, due_date, weight)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$subject_id, $title, $description, $due_date, $weight]);

// Redirigir de regreso al formulario con un mensaje
header("Location: /proyecto/frontend/dashboards/teacher/crear_actividad.php?ok=1");
exit;
