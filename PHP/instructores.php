<?php
include_once 'Conexion.php';

if (
    isset($_POST['nombre']) &&
    isset($_POST['documento']) &&
    isset($_POST['correo']) &&
    isset($_POST['telefono'])
) {
    $Nombre = $_POST['nombre'];
    $Documento = $_POST['documento'];
    $Correo = $_POST['correo'];
    $Telefono = $_POST['telefono'];
    date_default_timezone_set('America/Bogota');
    $fecha_registro = date('Y-m-d H:i:s');

    $query3 = "INSERT INTO instructores (Nombre_completo, documento, email, telefono, fecha_registro) 
                  VALUES ('$Nombre', '$Documento', '$Correo', '$Telefono', '$fecha_registro')";
    $eject = mysqli_query($conexion, $query3);

    if ($eject) {
        echo "<script>
                    alert('Instructor registrado correctamente');
                    window.location = '../instructores.php';
                  </script>";
    } else {
        echo "<script>
                    alert('Error al registrar el instructor');
                    window.location = '../instructores.php';
                  </script>";
    }
}

?>