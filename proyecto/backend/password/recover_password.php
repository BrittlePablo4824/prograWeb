<?php
require_once "../config/db.php";

$email = trim($_POST["email"] ?? "");

// Validamos que no venga vacío
if ($email === "") {
    echo "Debes escribir un correo";
    exit;
}

// Buscamos el correo del Usuario (búsqueda case-insensitive)
$stmt = $pdo->prepare("SELECT id, email FROM users WHERE LOWER(email) = LOWER(?)");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "El correo no existe";
    // Si quieres depurar, descomenta la línea de abajo temporalmente:
    // echo "<br>Probaste con: " . htmlspecialchars($email);
    exit;
}

// Redirigimos al Usuario a cambiar su contraseña
header("Location: /proyecto/frontend/password/reset_password.php?uid=" . $user["id"]);
exit;
