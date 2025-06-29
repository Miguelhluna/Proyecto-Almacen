<?php
session_start();
include_once 'Conexion.php';

if (
    isset($_POST['serial_equipo'], $_POST['marca'], $_POST['estado_novedad'],
          $_POST['tipo_novedad'], $_POST['descripcion'], $_FILES['prueba'])
) {
    $id_equipo = mysqli_real_escape_string($conexion, $_POST['serial_equipo']);
    $marca = mysqli_real_escape_string($conexion, $_POST['marca']);
    $estado_novedad = mysqli_real_escape_string($conexion, $_POST['estado_novedad']);
    $tipo_novedad = mysqli_real_escape_string($conexion, $_POST['tipo_novedad']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    date_default_timezone_set('America/Bogota');
    $fecha_novedad = date('Y-m-d H:i:s');

    // Manejo de archivo
    $archivo = $_FILES['prueba'];
    $nombreArchivo = basename($archivo['name']);
    if (isset($archivo['tmp_name']) && is_uploaded_file($archivo['tmp_name'])) {
    $tipoArchivo = mime_content_type($archivo['tmp_name']);
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Sin archivo',
        'texto' => 'No se detectó un archivo subido.'
    ];
    header("Location: ../inventario.php");
    exit();
}

    $tamanoArchivo = $archivo['size'];
    $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
    $rutaDestino = 'IMG/uploads/' . $nombreArchivo;

    if (!in_array($tipoArchivo, $permitidos)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Archivo inválido',
            'texto' => 'Solo se permiten imágenes JPG o PNG'
        ];
        header("Location: ../inventario.php");
        exit();
    }

    if ($tamanoArchivo > 2 * 1024 * 1024) { // 2MB máximo
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Archivo muy grande',
            'texto' => 'La imagen no debe superar los 2MB'
        ];
        header("Location: ../inventario.php");
        exit();
    }

    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        $query = "INSERT INTO novedad_equipos (id_equipo, marca, estado_novedad, tipo_novedad, descripcion, fecha_novedad, prueba)
                  VALUES ('$id_equipo', '$marca', '$estado_novedad', '$tipo_novedad', '$descripcion', '$fecha_novedad', '$rutaDestino')";

        if (mysqli_query($conexion, $query)) {
            $query2 = "UPDATE equipos SET Estado = 'inhabilitado' WHERE id_equipo = '$id_equipo'";
            if (mysqli_query($conexion, $query2)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'titulo' => '¡Hecho!',
                    'texto' => 'Novedad registrada correctamente'
                ];
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error al actualizar',
                    'texto' => 'No se pudo actualizar el estado del equipo'
                ];
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error en registro',
                'texto' => 'No se pudo registrar la novedad'
            ];
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error de archivo',
            'texto' => 'No se pudo subir la imagen'
        ];
    }

    header("Location: ../inventario.php");
    exit();
}
?>
