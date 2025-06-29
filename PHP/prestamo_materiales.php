<?php
session_start();
include 'Conexion.php';

if (
    isset($_POST['id_material']) &&
    isset($_POST['responsable2']) &&
    isset($_POST['cantidad'])
) {
    $idMaterial = mysqli_real_escape_string($conexion, $_POST['id_material']);
    $responsable = mysqli_real_escape_string($conexion, $_POST['responsable2']);
    $cantidad = (int) $_POST['cantidad'];

    // Validación: la cantidad debe ser positiva
    if ($cantidad <= 0) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Cantidad inválida',
            'texto' => 'La cantidad debe ser mayor a cero.'
        ];
        header("Location: ../prestamos.php");
        exit();
    }

    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

    // Buscar información del material
    $queryMaterial = "SELECT * FROM materiales WHERE id_material = $idMaterial";
    $resultMaterial = mysqli_query($conexion, $queryMaterial);

    if ($resultMaterial && mysqli_num_rows($resultMaterial) > 0) {
        $row = mysqli_fetch_assoc($resultMaterial);
        $tipo_material = $row['Tipo_Material'];
        $stock_actual = (int) $row['Stock'];

        // Verificar si hay suficiente stock
        if ($cantidad > $stock_actual) {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Stock insuficiente',
                'texto' => 'No hay suficiente stock para este préstamo.'
            ];
            header("Location: ../prestamos.php");
            exit();
        }

        // Asignar estado según tipo con switch
        $estado = '';
        switch ($tipo_material) {
            case 'Consumible':
                $estado = 'no devolutivo';
                break;
            case 'No Consumible':
                $estado = 'Prestado';
                break;
            default:
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error',
                    'texto' => 'Tipo de material no reconocido.'
                ];
                header("Location: ../prestamos.php");
                exit();
        }

        // Insertar el préstamo
        $queryInsert = "INSERT INTO prestamo_materiales 
            (id_material,tipo_material, cantidad, estado_prestamo, responsable, fecha_prestamo) 
            VALUES 
            ($idMaterial, '$tipo_material', $cantidad, '$estado', '$responsable', '$fecha')";

        $resultInsert = mysqli_query($conexion, $queryInsert);

        if ($resultInsert) {
            // Actualizar stock
            $nuevoStock = $stock_actual - $cantidad;
            $queryUpdate = "UPDATE materiales SET Stock = $nuevoStock WHERE id_material = $idMaterial";
            mysqli_query($conexion, $queryUpdate);

            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => 'Éxito',
                'texto' => 'Préstamo registrado correctamente.'
            ];
            // Redirigir a la página de préstamos
            header("Location: ../prestamos.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error al guardar',
                'texto' => 'No se pudo registrar el préstamo en la base de datos.'
            ];
            header("Location: ../prestamos.php");
            exit();
        }

    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Material no encontrado',
            'texto' => 'No se encontró el material con ese ID.'
        ];
        header("Location: ../prestamos.php");
        exit();
    }
}
?>