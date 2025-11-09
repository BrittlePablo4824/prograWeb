<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora Básica</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div class="contenedor">
        <h2>Calculadora Básica</h2>

        <form action="" method="post">
            <label>Primer número:</label>
            
            <input type="text" name="num1" placeholder="Ej. 5">

            <label>Segundo número:</label>
            <input type="text" name="num2" placeholder="Ej. 3">

            <div class="operaciones">
                <label><input type="radio" name="operacion" value="suma"> Suma (+)</label>
                <label><input type="radio" name="operacion" value="resta"> Resta (-)</label>
                <label><input type="radio" name="operacion" value="multiplicacion"> Multiplicación (×)</label>
                <label><input type="radio" name="operacion" value="division"> División (÷)</label>
            </div>

            <input type="submit" name="calcular" value="Calcular">
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operacion = $_POST['operacion'] ?? '';

            // Validación: campos vacíos
            if ($num1 === '' || $num2 === '') {
                echo "<p class='error'>Por favor, ingresa ambos números.</p>";
            }
            // Validación: solo números
            elseif (!is_numeric($num1) || !is_numeric($num2)) {
                echo "<p class='error'>Solo se permiten valores numéricos.</p>";
            }
            // Validación: operación no seleccionada
            elseif ($operacion == '') {
                echo "<p class='error'>Selecciona una operación.</p>";
            }
            else {
                // Cálculos
                switch ($operacion) {
                    case 'suma':
                        $resultado = $num1 + $num2;
                        break;
                    case 'resta':
                        $resultado = $num1 - $num2;
                        break;
                    case 'multiplicacion':
                        $resultado = $num1 * $num2;
                        break;
                    case 'division':
                        if ($num2 == 0) {
                            echo "<p class='error'>No se puede dividir entre 0.</p>";
                            exit;
                        }
                        $resultado = $num1 / $num2;
                        break;
                }

                echo "<p class='exito'>El resultado es: <strong>$resultado</strong></p>";
            }
        }
        ?>
    </div>
    <!-- Botones para regresar y reiniciar -->
        <div class="d-flex justify-content-center mt-4 gap-3">
            <a href="http://pablopenapadilla.atwebpages.com/" class="btn btn-outline-primary">⬅ Regresar a las actividades</a>
            <a href="index.php" class="btn btn-success"> Reiniciar calculadora</a>
        </div>

</body>
</html>
