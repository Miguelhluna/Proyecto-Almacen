<?php
// Verificar si la sesión está iniciada
include_once 'Conexion.php';

if (
    isset($_POST['id_equipo2']) &&
    isset($_POST['marca']) &&
    isset($_POST['serial_equipo']) &&
    isset($_POST['estado_novedad']) &&
    isset($_POST['tipo_novedad']) &&
    isset($_POST['descripcion'])
) {
    $id_equipo = $_POST['id_equipo2'];
    $marca = $_POST['marca'];
    $serial_equipo = $_POST['serial_equipo'];
    $estado_novedad = $_POST['estado_novedad'];
    $tipo_novedad = $_POST['tipo_novedad'];
    $descripcion = $_POST['descripcion'];
    date_default_timezone_set('America/Bogota');
    $fecha_novedad = date('Y-m-d H:i:s');
    // Verificar si la sesión está iniciada y el ID del usuario está disponible

    // Verificar si ya existe un instructor con ese documento
    $query = "INSERT INTO novedad_equipos (id_equipo, marca, serial_equipo, estado_novedad, tipo_novedad, descripcion, fecha_novedad) 
              VALUES ('$id_equipo', '$marca', '$serial_equipo', '$estado_novedad', '$tipo_novedad', '$descripcion', '$fecha_novedad')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $query2 = "UPDATE equipos SET Estado = 'inhabilitado' WHERE id_equipo = '$id_equipo'";
        $eject = mysqli_query($conexion, $query2);
        if (!$eject) {
            echo "<script>
                    alert('Error al actualizar el estado del equipo');
                    window.location = '../inventario.php';
                  </script>";
            exit;
        }
    }

    echo "<script>
            alert('Novedad registrada correctamente');
            window.location = '../inventario.php';
          </script>";
} 
?>