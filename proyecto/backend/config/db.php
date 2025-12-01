<?php   // Aquí vamos a crear el archivo de conexión para la base de datos
$host = "localhost";
$db = "proyectofinal";  // Estas 4 líneas guardan en variables los datos necesarios para conectarme a MySQL
$user = "root";
$pass = "";

try {
    // Código que puede fallar
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass); // Crea una conexión real a mi base de datos usando un objeto llamado PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Qué hacer si falla
    die("Error de conexión: " . $e->getMessage());  // Esto se usa para evitar que el sistema se rompa
}
