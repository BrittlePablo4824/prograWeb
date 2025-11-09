<?php
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<div class="container mt-5">';
echo '<div class="card shadow p-4">';
echo '<h1 class="text-center text-primary mb-4">SESSION / COOKIES</h1>';
echo '<div class="d-flex justify-content-center mt-4 gap-3">';
echo '</div>';
session_start();

// Credenciales estáticas
$usuarioValido = "admin";
$claveValida = "Tanjiro.13891";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $clave = trim($_POST["clave"]);
    $color = $_POST["color"];

    // Validación de campos vacíos
    if (empty($usuario) || empty($clave)) {
        $error = "Por favor llena todos los campos.";
    } elseif ($usuario === $usuarioValido && $clave === $claveValida) {
        // Guardamos datos en sesión
        $_SESSION["usuario"] = $usuario;
        $_SESSION["color"] = $color;
        header("Location: home.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
echo '<div class="d-flex justify-content-center mt-4 gap-3">';
echo '<a href="http://pablopenapadilla.atwebpages.com/" class="btn btn-outline-primary">⬅ Regresar a las actividades</a>';
echo '</div>';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login simple</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="post">
        Usuario: <input type="text" name="usuario"><br><br>
        Contraseña: <input type="password" name="clave"><br><br>
        Selecciona un color: 
        <input type="color" name="color" value="#104af6ff"><br><br>
        <input type="submit" value="Entrar">
    </form>

    <p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
