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
       $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => '¡Hecho!',
            'texto' => 'Novedad resuelta correctamente'
        ]; header("Location: ../inventario.php");
        exit();
    }
}

?>