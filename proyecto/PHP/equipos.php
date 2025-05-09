<?php

include 'Conexion.php';
$idEquipo = $_POST['id_equipo'];
$marca = $_POST['marca'];
$serial = $_POST['serial'];
$estado = $_POST['estado'];
date_default_timezone_set('America/Bogota');
$fechaRegistro = date('Y-m-d H:i:s');

$query = "INSERT INTO equipos (id_equipo, marca, serial_equipo, Estado, fecha_registro) VALUES ('$idEquipo', '$marca', '$serial', '$estado', '$fechaRegistro')";
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo "<script>alert('Equipo registrado correctamente')
    window.location = '../inventario.php';</script>";
} else {
    echo "Error al registrar el equipo: ".mysqli_error($conexion);
}
?>