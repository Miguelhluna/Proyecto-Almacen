<?php
include 'Conexion.php';

if (
    isset($_POST['id_equipo']) &&
    isset($_POST['responsable']) &&
    isset($_POST['estado_prestamo'])&&
    isset($_POST['cantidad'])
) {
    $responsable = mysqli_real_escape_string($conexion, $_POST['responsable']);
    $estado_prestamo = mysqli_real_escape_string($conexion, $_POST['estado_prestamo']);
    $id_equipos = $_POST['id_equipo']; // array
    date_default_timezone_set('America/Bogota');
    $fecha_prestamo = date('Y-m-d H:i:s');
    $cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);

    if (is_array($id_equipos) && !empty($id_equipos)) {
        // 1. Insertar el préstamo general
        $query = "INSERT INTO prestamos_equipos (responsable, fecha_prestamo, cantidad) VALUES ('$responsable', '$fecha_prestamo', '$cantidad')";
        // Ejecutar la consulta de inserción
        if (!mysqli_query($conexion, $query)) {
            die("Error al insertar el préstamo general: " . mysqli_error($conexion));
        }
        $id_prestamo = mysqli_insert_id($conexion); // Obtener el ID recién creado
        if (!$id_prestamo) {
            die("Error: No se pudo obtener el ID del préstamo recién creado.");
        }

        // 2. Insertar detalles de cada equipo y actualizar estado
        foreach ($id_equipos as $id_equipo) {
            $id_equipo = mysqli_real_escape_string($conexion, $id_equipo);

            // Verificar si el equipo ya está prestado
            $query_check = "SELECT Estado FROM equipos WHERE id_equipo = '$id_equipo'";
            $result_check = mysqli_query($conexion, $query_check);
            $row_check = mysqli_fetch_assoc($result_check);

            if ($row_check['Estado'] !== 'Disponible') {
                die("Error: El equipo con ID $id_equipo ya está prestado.");
            }

            // Insertar detalle del préstamo
            $query_detalle = "INSERT INTO detalle_prestamo_equipos (id_prestamo, id_equipo, estado_prestamo, cantidad)
                              VALUES ('$id_prestamo', '$id_equipo', 'Prestado', 1)";
            if (!mysqli_query($conexion, $query_detalle)) {
                die("Error al insertar el detalle del préstamo: " . mysqli_error($conexion));
            }

            // Actualizar estado del equipo a 'Prestado'
            $query_update = "UPDATE equipos SET Estado = 'Prestado' WHERE id_equipo = '$id_equipo'";
            if (!mysqli_query($conexion, $query_update)) {
                die("Error al actualizar el estado del equipo: " . mysqli_error($conexion));
            }
        }

        echo "<script>alert('✅ Préstamos registrados correctamente'); window.location = '../prestamos.php';</script>";
    } 
} else {
    echo "<script>alert('Error: Faltan datos en el formulario.'); window.history.back();</script>";
}

//devolver prestamo y cambiar de estado a disponible
if (isset($_POST['devolver'])) {
    $id_prestamo = $_POST['id_prestamo']; // ID del préstamo a devolver
    $id_equipo = $_POST['id_equipo']; // ID del equipo a devolver

    // Actualizar el estado del equipo a 'Disponible'
    $query_update = "UPDATE equipos SET Estado = 'Disponible' WHERE id_equipo = '$id_equipo'";
    if (!mysqli_query($conexion, $query_update)) {
        die("Error al actualizar el estado del equipo: " . mysqli_error($conexion));
    }

    // Eliminar el detalle del préstamo
    $query_delete = "DELETE FROM detalle_prestamo_equipos WHERE id_prestamo = '$id_prestamo' AND id_equipo = '$id_equipo'";
    if (!mysqli_query($conexion, $query_delete)) {
        die("Error al eliminar el detalle del préstamo: " . mysqli_error($conexion));
    }

    echo "<script>alert('✅ Préstamo devuelto correctamente'); window.location = '../prestamos.php';</script>";
}

mysqli_close($conexion);
?>

