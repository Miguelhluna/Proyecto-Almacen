<?php
include_once 'Conexion.php';

if (isset($_POST['id_prestamo'])) {
    $id = $_POST['id_prestamo'];

    $queryUpdate = "UPDATE detalle_prestamo_equipos SET estado_prestamo = 'devuelto' WHERE id_prestamo = '$id'";
    $resultadoUpdate = mysqli_query($conexion, $queryUpdate);
    if ($resultadoUpdate) {
        $queryUpdateEquipo = "UPDATE equipos SET estado = 'disponible' WHERE id_equipo IN (SELECT id_equipo FROM detalle_prestamo_equipos WHERE id_prestamo = '$id')";
        $resultadoUpdateEquipo = mysqli_query($conexion, $queryUpdateEquipo);

        echo "<script>alert('Devolución registrada correctamente');</script>";
        echo "<script>window.location.href = '../prestamos.php';</script>";

    } else {
        echo "<script>alert('Error al registrar la devolución');</script>";
    }
}
?>