<?php
include 'Conexion.php';

if (isset($_POST['id_prestamo'])) {
    $id_prestamo = $_POST['id_prestamo'];

    $query = "SELECT id_equipo FROM detalle_prestamo_equipos WHERE id_prestamo = '$id_prestamo'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1' style='width: 100%; border-collapse: collapse; text-align: center;'>";
        echo "<tr><th>ID Equipo</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['id_equipo'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay equipos asociados a este préstamo.";
    }
}
?>

