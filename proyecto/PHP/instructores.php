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

    // Verificar si ya existe un instructor con ese documento
    $query = "SELECT * FROM instructores WHERE numero_documento = '$Documento'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        // Ya existe: actualizar estado y datos
        $query2 = "UPDATE instructores SET 
                      Estado_funcionario = 'Activo',
                      Nombre_completo = '$Nombre',
                      email = '$Correo',
                      telefono = '$Telefono' 
                   WHERE numero_documento = '$Documento'";
        $eject = mysqli_query($conexion, $query2);

        if ($eject) {
            echo "<script>
                    alert('Instructor actualizado correctamente');
                    window.location = '../instructores.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al actualizar el instructor');
                    window.location = '../instructores.php';
                  </script>";
        }

    } else {
        // No existe: insertar nuevo instructor
        $query3 = "INSERT INTO instructores (Nombre_completo, numero_documento, email, telefono, fecha_registro) 
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
}
?>
