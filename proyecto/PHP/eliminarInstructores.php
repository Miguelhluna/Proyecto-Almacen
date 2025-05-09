<?php
include_once 'Conexion.php';

if (isset($_POST['cedula']) && isset($_POST['nombre'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    // Eliminar el instructor de la base de datos
    $query = "UPDATE instructores SET Estado_funcionario = 'Retirado' WHERE numero_documento = '$cedula'";
    $eject = mysqli_query($conexion, $query);

    if ($eject) {
        echo "<script>alert('Instructor Borrado correctamente')
        window.location = '../instructores.php';
        </script>";
    } else {
        echo "<script>alert('Error al eliminar el instructor')
        window.location = '../instructores.php';
        </script>";
    }
}
?>