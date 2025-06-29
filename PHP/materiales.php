<?php
session_start();
include 'Conexion.php';
date_default_timezone_set('America/Bogota');
$fechaRegistro = date('Y-m-d H:i:s');

// Validación básica
if (!isset($_POST['id_material'], $_POST['tipo_material'], $_POST['descripcion'], $_POST['cantidad'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'Faltan datos para registrar el material'
    ];
    header("Location: ../inventario.php");
    exit();
}

$idMaterial = $_POST['id_material'];
$tipoMaterial = $_POST['tipo_material'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];

// Verificar si el material ya existe
$queryCheck = "SELECT * FROM materiales WHERE id_Material = '$idMaterial'";
$resultCheck = mysqli_query($conexion, $queryCheck);

$accion = (mysqli_num_rows($resultCheck) > 0) ? 'actualizar' : 'insertar';

switch ($accion) {
    case 'actualizar':
        $queryUpdate = "UPDATE materiales SET Stock = Stock + '$cantidad' WHERE id_Material = '$idMaterial'";
        $ejecutarUpdate = mysqli_query($conexion, $queryUpdate);
        if ($ejecutarUpdate) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => '¡Hecho!',
                'texto' => 'Stock actualizado correctamente'
            ];
            header("Location: ../inventario.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'No se pudo actualizar el stock del material'
            ];
            header("Location: ../inventario.php");
            exit();
        }

    case 'insertar':
        $queryInsert = "INSERT INTO materiales (id_Material, Tipo_Material, Descripción, Stock, fecha_registro) 
                        VALUES ('$idMaterial', '$tipoMaterial', '$descripcion', '$cantidad', '$fechaRegistro')";
        $ejecutarInsert = mysqli_query($conexion, $queryInsert);
        if ($ejecutarInsert) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => '¡Hecho!',
                'texto' => 'Material registrado correctamente'
            ];
            header("Location: ../inventario.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'No se pudo registrar el material'
            ];
        }
        header("Location: ../inventario.php");
        exit();


}
mysqli_close($conexion);
exit;
?>