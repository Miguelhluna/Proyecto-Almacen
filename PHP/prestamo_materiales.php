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
<<<<<<< HEAD
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
=======
    $cantidad = (int) $_POST['cantidad'];  // Convertir a entero por seguridad
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f

    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

<<<<<<< HEAD
    // Buscar información del material
    $queryMaterial = "SELECT * FROM materiales WHERE id_material = $idMaterial";
=======
    // Obtener información del material (tipo, stock, etc.)
    $queryMaterial = "SELECT tipo_material, Stock FROM materiales WHERE id_material = $idMaterial";
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
    $resultMaterial = mysqli_query($conexion, $queryMaterial);

    if ($resultMaterial && mysqli_num_rows($resultMaterial) > 0) {
        $row = mysqli_fetch_assoc($resultMaterial);
<<<<<<< HEAD
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
=======
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
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f

        $resultInsert = mysqli_query($conexion, $queryInsert);

        if ($resultInsert) {
<<<<<<< HEAD
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
=======
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
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            ];
            header("Location: ../prestamos.php");
            exit();
        }

    } else {
<<<<<<< HEAD
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Material no encontrado',
            'texto' => 'No se encontró el material con ese ID.'
=======
        mysqli_close($conexion);
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Material no encontrado'
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
        ];
        header("Location: ../prestamos.php");
        exit();
    }
}
<<<<<<< HEAD
=======

/*Explicación rápida:
Se verifica si el material existe.

Si es consumible, se verifica el stock disponible y se descuenta.

Luego se hace el registro del préstamo completo*/
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
?>