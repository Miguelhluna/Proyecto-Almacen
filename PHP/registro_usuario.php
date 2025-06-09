<?php
include 'Conexion.php';
include 'manejoAlertas/alertaPrestamos.php';

$rol = $_POST['rol'];
$Nombre = $_POST['name'];
$Documento = $_POST['document'];
$Telefono = $_POST['phone'];
$Correo = $_POST['email'];
date_default_timezone_set('America/Bogota');
$registerDate = date('Y-m-d H:i:s');

//Verificar que el documento no esté registrado


$verify_document = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento'");

if (mysqli_num_rows($verify_document) > 0) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'El documento ya está registrado'
    ];
    header("Location: ../Administrador.php");
    exit();
} else {
    // Generar contraseña aleatoria solo si el rol es Almacenista
    if ($rol == "Almacenista") {
        $password = bin2hex(random_bytes(4)); // Generar una contraseña aleatoria de 8 caracteres
        $_SESSION['password_generada'] = $password;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña
        $query = "INSERT INTO usuarios (Nombre_completo, documento, email, telefono, Estado_funcionario, fecha_registro, rol, contraseña) VALUES ('$Nombre', '$Documento', '$Correo', '$Telefono', 'Activo', '$registerDate', '$rol', '$hashedPassword')";
        $eject = mysqli_query($conexion, $query);
        if ($eject) {
            #me muestre un mensaje de alerta al administrador con la contraseña en la página Administrador.php con sweet alert
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => '¡Almacenista registrado!',
                'texto' => "Nombre: $Nombre, Contraseña: $password"
            ];
            header("Location: ../Administrador.php");
            exit();
        }
    } else {
        $query = "INSERT INTO usuarios (Nombre_completo, documento, email, telefono, Estado_funcionario, fecha_registro, rol) VALUES ('$Nombre', '$Documento', '$Correo', '$Telefono', 'Activo', '$registerDate', '$rol')";
        $eject2 = mysqli_query($conexion, $query);
        if (!$eject2) {
            die("Error en la consulta SQL: " . mysqli_error($conexion));
            
        }
    }
}
mysqli_close($conexion);
?>