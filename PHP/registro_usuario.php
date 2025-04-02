<?php

include 'Conexion.php';

$Nombre = $_POST['name'];
$Documento = $_POST['document'];
$Telefono = $_POST['phone'];
$Correo = $_POST['email'];
$Contraseña = $_POST['password'];
$registerDate = date("Y-m-d");

//Verificar que el documento no esté registrado


$verify_document = mysqli_query ($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento'");
if (mysqli_num_rows($verify_document) > 0) {
    echo "<script>alert('El documento ya está registrado')
    window.location = '../login.php';
    </script>";
    exit();
}

$query = "INSERT INTO usuarios (Nombres, documento, email, telefono, contraseña, fecha_Registro) VALUES ('$Nombre', '$Documento', '$Telefono', '$Correo', '$Contraseña', '$registerDate')";
$eject = mysqli_query($conexion, $query);

if ($eject) {

    echo "<script>alert('Usuario registrado correctamente')
    window.location = '../login.php';
    </script>";
}


mysqli_close($conexion);
?>