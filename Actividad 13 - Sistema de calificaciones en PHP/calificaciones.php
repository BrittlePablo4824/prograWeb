<?php
// Enlace a Bootstrap (solo se imprime con echo)
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<div class="container mt-5">';
echo '<div class="card shadow p-4">';
echo '<h1 class="text-center text-primary mb-4">Resultados de los Estudiantes</h1>';
echo '<div class="d-flex justify-content-center mt-4 gap-3">';
echo '</div>';


// Definir constante
define("NUM_ALUMNOS", 5);

//Crear arreglo de estudiantes con calificaciones aleatorias
$estudiantes = [
    "Ana"   => rand(50, 100),
    "Luis"  => rand(50, 100),
    "Sofía" => rand(50, 100),
    "Pablo" => rand(50, 100),
    "Diana" => rand(50, 100)
];

//Función para calcular promedio general
function calcularPromedio($array) {
    $suma = array_sum($array);
    $total = count($array);
    return $suma / $total;
}

//Mostrar tabla de resultados
echo '<table class="table table-bordered text-center">';
echo '<thead class="table-primary">
        <tr>
            <th>Estudiante</th>
            <th>Calificación</th>
            <th>Resultado</th>
        </tr>
      </thead>';
echo '<tbody>';

foreach ($estudiantes as $nombre => $calificacion) {
    if ($calificacion >= 70) {
        $resultado = "Aprobado";
        $color = "text-success";
    } else {
        $resultado = "Reprobado";
        $color = "text-danger";
    }

    echo "<tr>
            <td>$nombre</td>
            <td>$calificacion</td>
            <td class='$color'>$resultado</td>
          </tr>";
}

echo '</tbody>';
echo '</table>';

//Botones alineados
echo '<div class="d-flex justify-content-center mt-4 gap-3">';
echo '<a href="http://pablopenapadilla.atwebpages.com/" class="btn btn-outline-primary">⬅ Regresar a las actividades</a>';
echo '<a href="" class="btn btn-success">🔄 Reiniciar promedios</a>';
echo '</div>';

//Promedio general más abajo con espacio extra
$promedio = calcularPromedio($estudiantes);
echo "<div class='text-center mt-5'>"; // mt-5 agrega espacio arriba
echo "<h4 class='alert alert-info'>Promedio general del grupo: <strong>" . number_format($promedio, 2) . "</strong></h4>";
echo "</div>";

echo '</div>';
echo '</div>';
?>