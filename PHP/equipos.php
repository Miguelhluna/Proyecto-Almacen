<?php
session_start();
include 'Conexion.php';
$marca = $_POST['marca'];
$serial = $_POST['serial'];
$estado = $_POST['estado'];
date_default_timezone_set('America/Bogota');
$fechaRegistro = date('Y-m-d H:i:s');

$query = "INSERT INTO equipos (id_equipo, marca, Estado, fecha_registro) VALUES ('$serial', '$marca', '$estado', '$fechaRegistro')";
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    //sweetalert2
    $_SESSION['mensaje'] = [
        'tipo' => 'success',
        'titulo' => '¡Hecho!',
        'texto' => 'Equipo registrado correctamente'
    ]; header("Location: ../inventario.php");
    exit();

} else {
    echo "Error al registrar el equipo: ".mysqli_error($conexion);
}
?>