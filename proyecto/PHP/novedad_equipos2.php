<?php
include_once 'Conexion.php';
session_start();

// Verificar que el id seleccionado no esté en estado resuelto antes de resolverlo
$idNovedad = $_POST['novedad'];

$query = "UPDATE novedad_equipos SET estado_novedad = 'Resuelta' WHERE id_novedad = '$idNovedad'";
$result = mysqli_query($conexion, $query);

if ($result) {
    // Actualizar el estado del equipo a 'Disponible'
    $query3 = "UPDATE equipos SET Estado = 'Disponible' WHERE id_equipo = ((SELECT id_equipo FROM novedad_equipos WHERE id_novedad = '$idNovedad'))";
    $eject = mysqli_query($conexion, $query3);
    if ($eject) {
        echo "<script>
                alert('Muy bien, la novedad ha sido resuelta');
                window.location = '../inventario.php';
              </script>";
        exit;
    }
}

?>