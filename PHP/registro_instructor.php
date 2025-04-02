<?php include 'conexion.php';

$Nombre = $_POST['nombre_completo'];
$TipoDocumento = $_POST['tipo_documento'];
$Documento = $_POST['cedula'];
$Correo = $_POST['correo_electrónico'];
$Telefono = $_POST['telefono'];

$queryinstructor = "INSERT INTO instructores (nombre_completo, tipo_documento, cedula, correo_electronico, telefono) VALUES ('$Nombre', '$TipoDocumento', '$Documento', '$Correo', '$Telefono')";
$eject = mysqli_query($conexion, $queryinstructor,);

if ($eject) {
    echo "Instructor registrado correctamente.";
} else {
    echo "Error al registrar el instructor: " . mysqli_error($conexion);
}

mysqli_close($conexion);




?>