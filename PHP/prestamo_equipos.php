<?php
include 'Conexion.php';
session_start();

if (
    isset($_POST['id_equipo']) &&
    isset($_POST['responsable']) &&
    isset($_POST['estado_prestamo']) &&
    isset($_POST['cantidad'])
) {
    $responsable = mysqli_real_escape_string($conexion, $_POST['responsable']);
    $estado_prestamo = mysqli_real_escape_string($conexion, $_POST['estado_prestamo']);
    $id_equipos = $_POST['id_equipo']; // array
    date_default_timezone_set('America/Bogota');
    $fecha_prestamo = date('Y-m-d H:i:s');
    $cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);

    #guardar datos en la sesión
    $_SESSION['datos_prestamo'] = [
        'responsable' => $responsable,
        'estado_prestamo' => $estado_prestamo,
        'fecha_prestamo' => $fecha_prestamo,
        'cantidad' => $cantidad
    ];

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
                # si el equipo está prestado mostrar alerta con sweetalert
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error',
                    'texto' => "El equipo con ID $id_equipo ya está prestado."
                ];
                header("Location: ../prestamos.php");
                exit();
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

        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => 'Éxito',
            'texto' => 'Préstamo registrado correctamente'
        ];
        header("Location: ../prestamos.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'No se seleccionaron equipos para el préstamo'
    ];
    header("Location: ../prestamos.php");
    exit();
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

    $_SESSION['mensaje'] = [
        'tipo' => 'success',
        'titulo' => 'Éxito',
        'texto' => 'Equipo devuelto correctamente'
    ];
    // Redirigir a la página de préstamos
    header("Location: ../prestamos.php");
    exit();
}

mysqli_close($conexion);
?>