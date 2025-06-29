<?php
include 'Conexion.php';
session_start();

// Manejo de devoluciones de materiales de tipo no consumible
if (isset($_POST['id_prestamoMaterial'])) {
    $idPrestamoMaterial = mysqli_real_escape_string($conexion, $_POST['id_prestamoMaterial']);

    // Consultar los datos del préstamo
    $devolucionPrestamo = "SELECT * FROM prestamo_materiales WHERE id_prestamoM = '$idPrestamoMaterial'";
    $resultDevolucion = mysqli_query($conexion, $devolucionPrestamo);

    if ($resultDevolucion && mysqli_num_rows($resultDevolucion) > 0) {
        $row = mysqli_fetch_assoc($resultDevolucion);
        $idMaterial = $row['id_material'];
        $cantidad = (int) $row['cantidad'];
        $tipo_material = $row['tipo_material'];
        $estadoPrestamo = $row['estado_prestamo'];

        // Validar que el préstamo sea de tipo 'No Consumible' y aún no haya sido devuelto
        if ($tipo_material === 'No consumible') {
            if ($estadoPrestamo === 'Prestado') {
                // Actualizar el stock del material
                $updateStock = "UPDATE materiales SET Stock = Stock + $cantidad WHERE id_material = '$idMaterial'";
                $successStock = mysqli_query($conexion, $updateStock);

                if ($successStock) {
                    // Cambiar el estado del préstamo a 'Devuelto'
                    $updatePrestamo = "UPDATE prestamo_materiales SET estado_prestamo = 'Devuelto' WHERE id_prestamoM = '$idPrestamoMaterial'";
                    $successEstado = mysqli_query($conexion, $updatePrestamo);

                    if ($successEstado) {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'success',
                            'titulo' => 'Devolución exitosa',
                            'texto' => 'El material ha sido devuelto correctamente.'
                        ];
                    } else {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'error',
                            'titulo' => 'Error al actualizar estado',
                            'texto' => 'No se pudo actualizar el estado del préstamo.'
                        ];
                    }
                } else {
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'titulo' => 'Error al actualizar stock',
                        'texto' => 'No se pudo actualizar el stock del material.'
                    ];
                }
            } elseif ($estadoPrestamo === 'Devuelto') {
                $_SESSION['mensaje'] = [
                    'tipo' => 'warning',
                    'titulo' => 'Ya devuelto',
                    'texto' => 'Este préstamo ya fue marcado como devuelto anteriormente.'
                ];
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'warning',
                    'titulo' => 'Estado no válido',
                    'texto' => 'Este préstamo no se encuentra en estado válido para devolución.'
                ];
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Artículo no devolutivo',
                'texto' => 'Este tipo de material no requiere devolución.'
            ];
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Préstamo no encontrado',
            'texto' => 'No se encontró el préstamo especificado.'
        ];
    }

    header("Location: ../prestamos.php");
    exit();
}
?>
