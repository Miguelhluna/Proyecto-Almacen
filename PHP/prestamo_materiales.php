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
    $cantidad = (int) $_POST['cantidad'];  // Convertir a entero por seguridad

    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

    // Obtener información del material (tipo, stock, etc.)
    $queryMaterial = "SELECT tipo_material, Stock FROM materiales WHERE id_material = $idMaterial";
    $resultMaterial = mysqli_query($conexion, $queryMaterial);

    if ($resultMaterial && mysqli_num_rows($resultMaterial) > 0) {
        $row = mysqli_fetch_assoc($resultMaterial);
        $tipo_material = $row['tipo_material'];
        $stock_actual = (int) $row['Stock'];

        if ($tipo_material === 'Consumible') {
            if ($cantidad > $stock_actual) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error',
                    'texto' => 'No hay suficiente stock disponible para este material'
                ];
                header("Location: ../prestamos.php");
                exit();
            }
        }

        // Registrar el préstamo
        $queryInsert = "INSERT INTO prestamo_materiales (id_material, tipo_material, cantidad, Responsable, fecha_prestamo) 
                        VALUES ('$idMaterial', '$tipo_material', '$cantidad', '$responsable', '$fecha')";

        $resultInsert = mysqli_query($conexion, $queryInsert);

        if ($resultInsert) {
            $nuevo_stock = $stock_actual - $cantidad;
            $updateStock = "UPDATE materiales SET Stock = $nuevo_stock WHERE id_material = $idMaterial";
            mysqli_query($conexion, $updateStock);
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => '¡Hecho!',
                'texto' => 'Préstamo registrado correctamente'
            ];
            mysqli_close($conexion);
            header("Location: ../prestamos.php");
            exit();
            // Actualizar el stock

        } else {
            mysqli_close($conexion);
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'No se pudo registrar el préstamo del material'
            ];
            header("Location: ../prestamos.php");
            exit();
        }

    } else {
        mysqli_close($conexion);
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Material no encontrado'
        ];
        header("Location: ../prestamos.php");
        exit();
    }
}

/*Explicación rápida:
Se verifica si el material existe.

Si es consumible, se verifica el stock disponible y se descuenta.

Luego se hace el registro del préstamo completo*/
?>